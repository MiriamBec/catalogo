<?php

use Illuminate\Support\Facades\Route;
use App\Models\Movie;
use Illuminate\Http\Request;

// Obtener todos los registros
Route::get('/movies', function () {
  return response()->json(Movie::all());
});

// Obtener una película por ID
Route::get('/movies/{id}', function ($id) {
  $movie = Movie::find($id);

  if ($movie) {
    return response()->json($movie);
  } else {
    return response()->json(['message' => 'Movie not found'], 404);
  }
});

// Crear un nuevo registro
Route::post('/movies', function (Request $request) {
  // Validar los datos
  $request->validate([
    'title' => 'required|string',
    'synopsis' => 'required|string',
    'year' => 'required|integer',
    'cover' => 'required|string',
  ]);

  // Crear un nuevo registro
  $movie = Movie::create([
    'title' => $request->input('title'),
    'synopsis' => $request->input('synopsis'),
    'year' => $request->input('year'),
    'cover' => $request->input('cover'),
  ]);

  return response()->json($movie, 201);
});

// Actualizar una película por ID usando PUT
Route::put('/movies/{id}', function (Request $request, $id) {
  $movie = Movie::find($id);

  if ($movie) {
    // Validar los datos antes de actualizar
    $request->validate([
      'title' => 'required|string',
      'synopsis' => 'required|string',
      'year' => 'required|integer',
      'cover' => 'required|string',
    ]);

    // Actualizar los datos de la película
    $movie->update([
      'title' => $request->input('title'),
      'synopsis' => $request->input('synopsis'),
      'year' => $request->input('year'),
      'cover' => $request->input('cover'),
    ]);

    return response()->json(['message' => 'Movie updated successfully', 'movie' => $movie], 200);
  } else {
    return response()->json(['message' => 'Movie not found'], 404);
  }
});

// Eliminar una película por ID usando DELETE
Route::delete('/movies/{id}', function ($id) {
  $movie = Movie::find($id);

  if ($movie) {
    $movie->delete();
    return response()->json(['message' => 'Movie deleted successfully'], 200);
  } else {
    return response()->json(['message' => 'Movie not found'], 404);
  }
});
