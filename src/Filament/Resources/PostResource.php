<?php

namespace irajul\Blogflow\Filament\Resources;

use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use irajul\Blogflow\Enums\Status;
use irajul\Blogflow\Enums\Type;
use irajul\Blogflow\Filament\Resources\PostResource\Pages\CreatePost;
use irajul\Blogflow\Filament\Resources\PostResource\Pages\EditPost;
use irajul\Blogflow\Filament\Resources\PostResource\Pages\ListPosts;
use irajul\Blogflow\Models\Post;
use League\Flysystem\UnableToCheckFileExistence;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::RectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('post_tabs')->schema([
                    Tab::make(__('Title & Content'))->schema([
                        TextInput::make('title')
                            ->label(__('Post Title'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, $state, $context) {
                                if ($context === 'edit') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            }),
                        MarkdownEditor::make('content')
                            ->label(__('Post Content'))
                            ->fileAttachmentsDisk(config('blogflow.disk'))
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('blog_assets')
                            ->getUploadedAttachmentUrlUsing(function ($file) {
                                $disk_name = config('blogflow.disk');
                                $storage = Storage::disk($disk_name);

                                try {
                                    if (! $storage->exists($file)) {
                                        return null;
                                    }
                                } catch (UnableToCheckFileExistence $exception) {
                                    return null;
                                }

                                return $storage->url($file);
                            })
                            ->saveUploadedFileAttachmentsUsing(function ($file) {
                                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                $storeMethod = 'storePubliclyAs';
                                $extension = $file->getClientOriginalExtension();
                                $directory = 'blog_assets';
                                $disk_name = config('blogflow.disk');
                                if (Storage::disk($disk_name)->exists(ltrim($directory . '/' . $filename . '.' . $extension, '/'))) {
                                    $filename = $filename . '-' . time();
                                }
                                $upload = $file->{$storeMethod}($directory, $filename . '.' . $extension, $disk_name);

                                return $upload;
                            }),

                    ]),

                    Tab::make(__('SEO'))->schema([
                        // Placeholder::make(__('Search Engine Optimization')),

                        Select::make('user_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->required(),

                        Select::make('post_type')
                            ->default('post')
                            ->required()
                            ->options(Type::class),

                        Textarea::make('meta_title')
                            ->maxLength(255)
                            ->label(__('Meta Title'))
                            ->hint(__('Meta Title')),

                        Textarea::make('meta_description')
                            ->maxLength(255)
                            ->label(__('Meta Description'))
                            ->hint(__('Meta Description')),

                        TextInput::make('estimated_reading_time')
                            ->label(__('Estimated Reading Time'))
                            ->hint(__('Estimated Reading Time')),

                        TextInput::make('slug')
                            ->unique(ignorable: fn (?Post $record): ?Post => $record)
                            ->required()
                            ->maxLength(255)
                            ->label(__('Post Slug')),
                    ]),
                    Tab::make(__('Tags'))->schema([
                        // Placeholder::make(__('Tags and Categories')),
                        SpatieTagsInput::make('tags')
                            ->type(config('blogflow.tables.prefix') . 'post_tag')
                            ->label(__('Tags')),

                        SpatieTagsInput::make('category')
                            ->type(config('blogflow.tables.prefix') . 'post_category')
                            ->label(__('Categories')),

                    ]),

                    Tab::make(__('Visibility'))->schema([
                        // Placeholder::make(__('Visibility Options')),
                        Select::make('status')
                            ->label(__('Status'))
                            ->default(Status::Published->value)
                            ->required()
                            ->live()
                            ->options(Status::class),

                        TextInput::make('password')
                            ->label(__('Password'))
                            ->visible(fn (Get $get): bool => $get('status') === 'private'),

                        DateTimePicker::make('published_at')
                            ->label(__('Published at'))
                            ->native(false)
                            ->default(now()),

                        DateTimePicker::make('sticky_until')
                            ->native(false)
                            ->label(__('Sticky Until')),
                    ]),

                    Tab::make(__('Image'))->schema([
                        // Placeholder::make(__('Featured Image')),

                        SpatieMediaLibraryFileUpload::make('featured_image_upload')
                            ->collection(config('blogflow.featured_image.collection_name'))
                            ->disk(config('blogflow.disk'))
                            ->label('Feature Image')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->imageResizeMode('cover')
                            ->imageEditor()
                            ->imageEditorMode(2)
                            ->imageResizeUpscale(false)
                            ->maxSize(1024)
                            ->customHeaders(['CacheControl' => 'max-age=86400']),

                        // feature image title and alt text
                        TextInput::make('featured_image.title')
                            ->label(__('Featured Image Title')),
                        TextInput::make('featured_image.alt')
                            ->label(__('Featured Image Alt')),
                    ]),
                ])
                    ->columnSpan('full'),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('post_type')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),

                TextColumn::make('views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('post_type')
                    ->options(Type::class)
                    ->default(Type::Post->value),
                SelectFilter::make('status')
                    ->options(Status::class)
                    ->default(Status::Published->value),
            ])
            ->recordActions([
                EditAction::make(),
                // Tables\Actions\ViewAction::make('view')
                //     ->label('View')
                //     ->url(fn (Post $record) => route($record->route_name, $record->slug))
                //     ->icon('heroicon-o-eye')
                //     ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
