<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\Action;
use App\Filament\Resources\ResolucionResource\Pages;
use App\Filament\Resources\ResolucionResource\RelationManagers;
use App\Models\Resolucion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ResolucionResource extends Resource
{
    protected static ?string $model = Resolucion::class;

    protected static ?string $navigationLabel = 'Resoluciones';

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('n_resolucion')->label('N° Resolucion')->required(),
                Forms\Components\Section::make('')
                ->schema([
                    Forms\Components\TextInput::make('n_resolucion')->label('N° Resolucion')->required(),
                    Forms\Components\DatePicker::make('fecha')->label('Fecha')->required()->format('Y-m-d'),
                    Forms\Components\TextInput::make('ano')->label('Año')->required()->numeric(),
                    Forms\Components\Hidden::make('usuario_id')->default(Auth::id()),

                    Forms\Components\Textarea::make('concepto')->label('Concepto')->required()->columnSpan(3),

                    Forms\Components\FileUpload::make('ruta_archivo')
                    ->label('Subir Resolución')
                    ->disk('public')
                    ->directory('resoluciones')
                    ->preserveFilenames()
                    ->storeFileNamesIn('nombre_original')
                    ->required()
                    ->columnSpan(3),
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('n_resolucion')->label('N° Resolución')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('concepto')->label('Concepto')->limit(50),
                Tables\Columns\TextColumn::make('fecha')->label('Fecha')->date()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('ano')->label('Año')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('usuario.name')->label('Agregado por')->searchable()->toggleable(true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Action::make('descargar')
                ->label('Descargar')
                ->icon('heroicon-c-arrow-down-tray')
                ->url(fn (Resolucion $record): string => route('descargar.resolucion', $record))
                ->openUrlInNewTab(),                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListResolucions::route('/'),
            'create' => Pages\CreateResolucion::route('/create'),
            'edit' => Pages\EditResolucion::route('/{record}/edit'),
        ];
    }
}
