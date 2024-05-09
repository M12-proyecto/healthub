<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Models\User;

class ChatController extends Controller
{

    public function show() {
        return view('chat');
    }

    // Método para enviar un mensaje
    public function sendMessage(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'chat_id' => 'required|integer',
            'paciente_id' => 'required|integer',
            'medico_id' => 'required|integer',
            'mensaje' => 'required|string',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i:s',
        ]);

        // Crear un nuevo mensaje
        $mensaje = new Mensaje([
            'chat_id' => $request->input('chat_id'),
            'paciente_id' => $request->input('paciente_id'),
            'medico_id' => $request->input('medico_id'),
            'mensaje' => $request->input('mensaje'),
            'fecha' => $request->input('fecha'),
            'hora' => $request->input('hora'),
        ]);

        // Guardar el mensaje en la base de datos
        $mensaje->save();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Mensaje enviado correctamente'], 200);
    }

    // Método para obtener todos los mensajes
    public function getMessages()
    {
        // Obtener todos los mensajes
        $mensajes = Mensaje::all();

        // Retornar los mensajes en formato JSON
        return response()->json($mensajes, 200);
    }

    // Método para eliminar un usuario
    public function deleteUser($id)
    {
        // Buscar al usuario por su ID
        $usuario = User::find($id);

        // Verificar si el usuario existe
        if (!$usuario) {
            // Retornar un mensaje de error si el usuario no se encuentra
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Eliminar el usuario
        $usuario->delete();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }

    // Método para eliminar un mensaje
    public function deleteMessage($id)
    {
        // Buscar el mensaje por su ID
        $mensaje = Mensaje::find($id);

        // Verificar si el mensaje existe
        if (!$mensaje) {
            // Retornar un mensaje de error si el mensaje no se encuentra
            return response()->json(['message' => 'Mensaje no encontrado'], 404);
        }

        // Eliminar el mensaje
        $mensaje->delete();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Mensaje eliminado correctamente'], 200);
    }
}
