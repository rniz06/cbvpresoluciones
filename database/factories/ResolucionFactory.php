<?php

namespace Database\Factories;

use App\Models\Resolucion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resolucion>
 */
class ResolucionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Resolucion::class;

    public function definition(): array
    {
        // Generar la fecha aleatoria
        $fecha = $this->faker->date();

        // Generar un array de IDs aleatorios para compania_id y personal_id
        $companiaIds = [$this->faker->numberBetween(1, 100), $this->faker->numberBetween(1, 100)];
        $personalIds = [$this->faker->numberBetween(1, 100), $this->faker->numberBetween(1, 100)];

        return [
            'n_resolucion' => $this->faker->randomNumber(4) . '/' . $this->faker->year(), // Número aleatorio seguido de una barra y un año
            'concepto' => $this->faker->text(200),  // Texto aleatorio para el concepto
            'fecha' => $fecha,  // Fecha aleatoria generada
            'ano' => Carbon::parse($fecha)->year,  // Obtener el año de la fecha generada
            'ruta_archivo' => $this->faker->filePath(),
            'nombre_original' => $this->faker->word . '.pdf',
            'archivo_nombre_generado' => $this->faker->word . '_gen.pdf',
            'archivo_tamano' => $this->faker->numberBetween(100, 10000) . ' KB', // Tamaño aleatorio
            'archivo_tipo' => 'application/pdf', // Puedes cambiarlo si es necesario
            'usuario_id' => 1,  // Crea un usuario aleatorio con su propio factory
            // Generar IDs numéricos aleatorios para compania_id y personal_id
            // Ahora generamos arrays de IDs para los campos compania_id y personal_id
        'compania_id' => $companiaIds,  // Array con dos IDs aleatorios de compañias
        'personal_id' => $personalIds,  // Array con dos IDs aleatorios de personal
        ];
    }
}
