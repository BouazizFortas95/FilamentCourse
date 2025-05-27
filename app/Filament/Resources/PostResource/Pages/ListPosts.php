<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            // Tabs::make()->schema([
                Tab::make('All'),
                Tab::make('Published')->modifyQueryUsing(function (Builder $query): Builder {
                    return $query->where('published', true);
                }),
                Tab::make('Unpublished')->modifyQueryUsing(function (Builder $query): Builder {
                    return $query->where('published', false);
                }),
            // ]),
        ];
    }
}
