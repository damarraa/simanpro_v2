<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyProjectReportResource\Pages;
use App\Filament\Resources\DailyProjectReportResource\RelationManagers;
use App\Filament\Resources\DailyProjectReportResource\RelationManagers\WorkActivitiesRelationManager;
use App\Models\DailyProjectReport;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class DailyProjectReportResource extends Resource
{
    protected static ?string $model = DailyProjectReport::class;
    protected static ?string $navigationGroup = 'Manajemen Proyek';
    protected static ?string $navigationLabel = 'Laporan Harian';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('project_id')
                            ->relationship('project', 'job_name')
                            ->searchable()
                            ->preload()
                            ->label('Proyek')
                            ->required()
                            ->live(),

                        DatePicker::make('report_date')
                            ->label('Tanggal Laporan')
                            ->default(now())
                            ->required()
                            ->unique(
                                ignoreRecord: true,
                                modifyRuleUsing: fn(Unique $rule, Get $get) => $rule->where('project_id', $get('project_id'))
                            ),
                    ]),

                Radio::make('weather')
                    ->label('Kondisi Cuaca')
                    ->options([
                        'Cerah' => 'Cerah',
                        'Berawan' => 'Berawan',
                        'Hujan' => 'Hujan',
                    ])
                    ->columns(3),

                Grid::make(3)
                    ->schema([
                        TextInput::make('personnel_count')
                            ->label('Jumlah Petugas')
                            ->numeric()
                            ->required(),

                        TimePicker::make('start_time')
                            ->label('Jam Mulai'),

                        TimePicker::make('end_time')
                            ->label('Jam Selesai'),
                    ]),

                Textarea::make('notes')
                    ->label('Catatan Umum Harian')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('report_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('project.job_name')
                    ->label('Proyek')
                    ->searchable(),

                TextColumn::make('weather')
                    ->label('Cuaca'),

                TextColumn::make('submittedBy.name')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            WorkActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyProjectReports::route('/'),
            'create' => Pages\CreateDailyProjectReport::route('/create'),
            'edit' => Pages\EditDailyProjectReport::route('/{record}/edit'),
        ];
    }
}
