<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstitucionResource\Pages;
use App\Filament\Resources\InstitucionResource\RelationManagers;
use App\Models\Institucion;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstitucionResource extends Resource
{
    protected static ?string $model = Institucion::class;

    protected static ?string $label = "Instituciones";

    protected static ?string $slug = "instituciones";

    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\TextInput::make('nombre')->label('Institución:')->required()->maxLength(100),
                    Forms\Components\TextInput::make('representante')->label('Representante:')->required()->maxLength(100),
                    Forms\Components\TextInput::make('domicilio')->maxLength(100),
                    Forms\Components\TextInput::make('correo')->email()->maxLength(40),
                    Forms\Components\TextInput::make('telefono')->numeric(),
                    Forms\Components\Select::make('ciudad_id')->relationship('ciudad', 'ciudad')->searchable(),
                    Forms\Components\Select::make('pais_id')->relationship('pais', 'pais')->searchable(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')->toggleable()->label('Institución')->sortable(),
                TextColumn::make('domicilio')->toggleable()->label('Domicilio')->sortable(),
                TextColumn::make('correo')->toggleable()->label('Correo')->sortable(),
                TextColumn::make('telefono')->toggleable()->label('Telefono')->sortable(),
                TextColumn::make('ciudad.ciudad')->toggleable()->label('Ciudad')->sortable(),
                TextColumn::make('pais.pais')->toggleable()->label('Pais')->sortable(),
                TextColumn::make('representante')->toggleable()->label('Representante')->sortable(),
            ])
            ->filters([
                Filter::make('nombre')
                    ->form([
                        Forms\Components\TextInput::make('nombre')->label('Institucion:'),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nombre'],
                            fn(Builder $query, $nombre): Builder => $query->where('nombre', 'like', '%' . $nombre . '%')
                        );
                    }),
                Filter::make('domicilio')
                    ->form([
                        Forms\Components\TextInput::make('domicilio')->label('Domicilio:'),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['domicilio'],
                            fn(Builder $query, $domicilio): Builder => $query->where('domicilio', 'like', '%' . $domicilio . '%')
                        );
                    }),
                Filter::make('correo')
                    ->form([
                        Forms\Components\TextInput::make('correo')->label('Correo:'),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['correo'],
                            fn(Builder $query, $correo): Builder => $query->where('correo', 'like', '%' . $correo . '%')
                        );
                    }),
                Filter::make('telefono')
                    ->form([
                        Forms\Components\TextInput::make('telefono')->label('Telefono:'),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['telefono'],
                            fn(Builder $query, $telefono): Builder => $query->where('telefono', 'like', '%' . $telefono . '%')
                        );
                    }),
                SelectFilter::make('ciudad_id')
                    ->label('Ciudad:')
                    //->relationship('ciudad', 'ciudad')
                    ->multiple(),
                SelectFilter::make('pais_id')
                    ->label('Pais:')
                    //->relationship('ciudad', 'ciudad')
                    ->multiple(),
            ],  layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([5, 10, 15, 20, 25])
            ->defaultPaginationPageOption(5);
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
            'index' => Pages\ListInstitucions::route('/'),
            'create' => Pages\CreateInstitucion::route('/create'),
            'edit' => Pages\EditInstitucion::route('/{record}/edit'),
        ];
    }
}
