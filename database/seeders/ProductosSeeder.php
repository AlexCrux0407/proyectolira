<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            ['nombre' => 'Hamburguesa Clásica', 'descripcion' => 'Hamburguesa con carne, lechuga, tomate y salsa especial', 'precio' => 85.00, 'categoria' => 'Hamburguesas'],
            ['nombre' => 'Hamburguesa con Queso', 'descripcion' => 'Hamburguesa con carne, queso, lechuga, tomate y salsa especial', 'precio' => 95.00, 'categoria' => 'Hamburguesas'],
            ['nombre' => 'Hamburguesa Doble', 'descripcion' => 'Doble carne, doble queso, lechuga, tomate y salsa especial', 'precio' => 125.00, 'categoria' => 'Hamburguesas'],
            ['nombre' => 'Pizza Margarita', 'descripcion' => 'Pizza con salsa de tomate, mozzarella y albahaca', 'precio' => 140.00, 'categoria' => 'Pizzas'],
            ['nombre' => 'Pizza Pepperoni', 'descripcion' => 'Pizza con salsa de tomate, mozzarella y pepperoni', 'precio' => 160.00, 'categoria' => 'Pizzas'],
            ['nombre' => 'Pizza Hawaiana', 'descripcion' => 'Pizza con salsa de tomate, mozzarella, jamón y piña', 'precio' => 170.00, 'categoria' => 'Pizzas'],
            ['nombre' => 'Ensalada César', 'descripcion' => 'Lechuga, crutones, pollo, queso parmesano y aderezo César', 'precio' => 90.00, 'categoria' => 'Ensaladas'],
            ['nombre' => 'Ensalada Mixta', 'descripcion' => 'Lechuga, tomate, cebolla, zanahoria y aderezo de la casa', 'precio' => 70.00, 'categoria' => 'Ensaladas'],
            ['nombre' => 'Papas Fritas', 'descripcion' => 'Porción de papas fritas con sal', 'precio' => 45.00, 'categoria' => 'Complementos'],
            ['nombre' => 'Aros de Cebolla', 'descripcion' => 'Aros de cebolla empanizados', 'precio' => 55.00, 'categoria' => 'Complementos'],
            ['nombre' => 'Refresco', 'descripcion' => 'Refresco de cola, limón o naranja', 'precio' => 30.00, 'categoria' => 'Bebidas'],
            ['nombre' => 'Agua Mineral', 'descripcion' => 'Agua mineral natural o con gas', 'precio' => 25.00, 'categoria' => 'Bebidas'],
            ['nombre' => 'Cerveza', 'descripcion' => 'Cerveza nacional', 'precio' => 45.00, 'categoria' => 'Bebidas'],
            ['nombre' => 'Pastel de Chocolate', 'descripcion' => 'Pastel de chocolate con frosting', 'precio' => 60.00, 'categoria' => 'Postres'],
            ['nombre' => 'Helado', 'descripcion' => 'Helado de vainilla, chocolate o fresa', 'precio' => 40.00, 'categoria' => 'Postres'],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}