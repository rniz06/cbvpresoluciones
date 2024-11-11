<?php

namespace Database\Factories;

use App\Models\Resolucion;
use App\Models\User;
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
        return [
            'n_resolucion' => $this->faker->unique()->word . '-' . $this->faker->randomNumber(4),
            'concepto' => $this->faker->text(200),  // Texto aleatorio para el concepto
            'fecha' => $this->faker->date(),
            'ano' => $this->faker->year(),
            'ruta_archivo' => $this->faker->filePath(),
            'nombre_original' => $this->faker->word . '.pdf',
            'archivo_nombre_generado' => $this->faker->word . '_gen.pdf',
            'archivo_tamano' => $this->faker->numberBetween(100, 10000) . ' KB', // Tamaño aleatorio
            'archivo_tipo' => 'application/pdf', // Puedes cambiarlo si es necesario
            'usuario_id' => User::factory(),  // Crea un usuario aleatorio con su propio factory
            'compania_id' => $this->faker->word,  // Asumiendo que es texto
            'personal_id' => $this->faker->word,  // Asumiendo que es texto
        ];
    }
}
