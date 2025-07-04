<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\ProjectResource\RelationManagers\ExpensesRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\ProjectWorkItemRelationManager;
use App\Filament\Resources\ProjectResource\RelationManagers\TeamRelationManager;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationGroup = 'Manajemen Proyek';
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function getNavigationLabel(): string
    {
        return 'Manajemen Proyek';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->columns([
                                'default' => 1,   // Mobile default 1 kolom
                                'md' => 2,        // Tablet 2 kolom
                                'lg' => 4         // Desktop 4 kolom
                            ])
                            ->schema([
                                TextInput::make('contract_num')
                                    ->label('Nomor Kontrak')
                                    ->required(),

                                TextInput::make('job_name')
                                    ->label('Nama Pekerjaan')
                                    ->required(),

                                Select::make('job_id')
                                    ->label('Kategori Proyek')
                                    ->relationship('job', 'job_type')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('job_type')
                                            ->label('Kategori Proyek')
                                            ->required(),
                                    ]),

                                TextInput::make('contract_type')
                                    ->label('Jenis Kontrak')
                                    ->required(),

                                DatePicker::make('start_date')
                                    ->label('Tanggal Mulai')
                                    ->required(),

                                DatePicker::make('end_date')
                                    ->label('Tanggal Selesai')
                                    ->required(),

                                TextInput::make('contract_value')
                                    ->label('Nilai Kontrak')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->inputMode('decimal')
                                    ->required(),

                                TextInput::make('fund_source')
                                    ->label('Sumber Dana Kontrak')
                                    ->required(),

                                // Lokasi (span 2 kolom)
                                Textarea::make('location')
                                    ->label('Lokasi')
                                    ->required()
                                    ->columnSpan([
                                        'default' => 1,
                                        'md' => 2,
                                        'lg' => 2,
                                    ]),

                                Select::make('client_id')
                                    ->label('Pemberi Pekerjaan')
                                    ->relationship('client', 'client_name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('client_name')
                                            ->label('Nama Client')
                                            ->required(),
                                    ]),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'On-Progress' => 'On-Progress',
                                        'Completed' => 'Completed',
                                        'Cancelled' => 'Cancelled',
                                        'Pending' => 'Pending'
                                    ]),

                                Select::make('default_warehouse_id')
                                    ->label('Gudang Default Untuk Proyek Ini')
                                    ->relationship('defaultWarehouse', 'warehouse_name')
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Pilih gudang utama tempat material untuk proyek ini akan diambil.'),

                                // Latitude dan Longitude
                                TextInput::make('latitude')
                                    ->label('Latitude'),

                                TextInput::make('longitude')
                                    ->label('Longitude'),

                                TextInput::make('total_budget')
                                    ->label('Total Budget'),

                                Select::make('project_manager_id')
                                    ->label('Project Manager')
                                    ->relationship('projectManager', 'name') // Menggunakan relasi yang sudah Anda buat
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_name')
                    ->label('Nama Proyek')
                    ->searchable(),

                TextColumn::make('contract_num')
                    ->label('Nomor Kontrak')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('client.client_name')
                    ->label('Pemberi Pekerjaan')
                    ->searchable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),

                TextColumn::make('projectManager.name')
                    ->label('Project Manager')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('client')
                    ->relationship('client', 'client_name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            ProjectWorkItemRelationManager::class,
            TeamRelationManager::class,
            ExpensesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
