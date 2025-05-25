<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Data information')
                        ->collapsible()
                        ->schema([
                            TextInput::make('title')
                                ->rules(['min:3', 'max:255', 'string'])
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                            TextInput::make('slug')->required()->readOnly(),
                            Select::make('category_id')
                                ->label('Category')
                                ->options(Category::all()->pluck('name', 'id'))
                                ->searchable(),
                            Toggle::make('published')->required(),
                        ]),
                ]),
                Group::make()->schema([
                    Section::make('Description')
                        ->collapsible()
                        ->schema([
                            ColorPicker::make('color')->required(),
                            MarkdownEditor::make('content')->required(),
                        ]),
                ]),
                Group::make()->schema([
                    Section::make('Meta')
                        ->collapsible()
                        ->schema([
                            TagsInput::make('tags')->required(),
                            FileUpload::make('thumbnail')->disk('public')->directory('posts'),
                        ]),
                ]),
            ])->columns([
            'default' => 1,
            'sm' => 2,
            'md' => 2,
            'lg' => 3,
            'xl' => 3,
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('thumbnail')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category.name')->sortable()->searchable()->toggleable(),
                TextColumn::make('title')->sortable()->searchable()->toggleable(),
                TextColumn::make('slug')->toggleable(),
                ColorColumn::make('color')->toggleable(),
                TextColumn::make('tags')->sortable()->searchable()->toggleable(),
                CheckboxColumn::make('published')->toggleable(false),
                TextColumn::make('created_at')->label('Published on')->date('Y M d')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
