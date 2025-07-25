<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Usuarios\UpdateUsuarioRequest;
use App\Http\Requests\Usuarios\RegisterUsuarioRequest;

class AuthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/usuarios",
     *     tags={"Usuarios"},
     *     summary="Listar todos los usuarios",
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UsuarioSchema"))
     *     )
     * )
     */
    public function index()
    {
        // Listas de todas los usuarios
        $usuarios = User::with(['rol'])->get();

        return response()->json([
            'data' => $usuarios,
            'total' => $usuarios->count(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios/paginated",
     *     tags={"Usuarios"},
     *     summary="Obtiene la lista paginada de usuarios con búsqueda",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Número de página"
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Cantidad de resultados por página"
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Texto a buscar en el nombre del usuario"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de usuarios",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/UsuarioSchema")),
     *             @OA\Property(property="total", type="integer", example=100),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=10)
     *         )
     *     )
     * )
     */
    public function paginated(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 10);
        $search = $request->query('search');

        // Inicia la consulta base con la relación
        $query = User::with('rol');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
                // Puedes agregar más campos si deseas que busque en varios
            });
        }

        $usuarios = $query->orderBy('id', 'asc')->paginate($perPage);

        return response()->json($usuarios);
    }

    /**
     * @OA\Post(
     *     path="/api/usuarios/register",
     *     summary="Crear un nuevo usuario",
     *     description="Esta ruta permite crear un nuevo usuario con imagen opcional. Acepta JSON o multipart/form-data.",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"nombre", "apellido", "correo", "idrol"},
     *                 @OA\Property(property="nombre", type="string", example="Juan"),
     *                 @OA\Property(property="apellido", type="string", example="Pérez"),
     *                 @OA\Property(property="correo", type="string", format="email", example="juan@correo.com"),
     *                 @OA\Property(property="telefono", type="string", example="0991234567"),
     *                 @OA\Property(property="password", type="string", example="secreta123"),
     *                 @OA\Property(property="idrol", type="integer", example=2),
     *                 @OA\Property(property="estado", type="boolean", example=true)
     *             )
     *         ),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"nombre", "apellido", "correo", "idrol"},
     *                 @OA\Property(property="nombre", type="string", example="Juan"),
     *                 @OA\Property(property="apellido", type="string", example="Pérez"),
     *                 @OA\Property(property="correo", type="string", format="email", example="juan@correo.com"),
     *                 @OA\Property(property="telefono", type="string", example="0991234567"),
     *                 @OA\Property(property="password", type="string", example="secreta123"),
     *                 @OA\Property(property="idrol", type="integer", example=2),
     *                 @OA\Property(property="estado", type="boolean", example=true),
     *                 @OA\Property(
     *                     property="foto",
     *                     type="string",
     *                     format="binary",
     *                     description="Archivo de imagen JPG o PNG (opcional)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario creado correctamente"),
     *             @OA\Property(property="user", ref="#/components/schemas/UsuarioSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "idrol": {"The selected idrol is invalid."},
     *                     "foto": {"The foto field must be an image."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function register(RegisterUsuarioRequest $request): JsonResponse
    {
        // Auditoría del contexto
        AuditoriaService::setContextInfo('RegistroDeUsuario');

        // Validación de campos
        $validatedData = $request->validated();

        // Foto
        $rutaFoto = $request->hasFile('foto')
            ? $request->file('foto')->store('fotos_usuarios', 'public')
            : 'fotos_usuarios/default.jpg';

        // Password
        $password = $validatedData['password'] ?? Str::random(8);

        // Crear usuario
        $user = User::create([
            'nombre' => $validatedData['nombre'],
            'apellido' => $validatedData['apellido'],
            'correo' => $validatedData['correo'],
            'telefono' => $validatedData['telefono'],
            'password' => Hash::make($password),
            'estado' => $validatedData['estado'] ?? true,
            'idrol' => $validatedData['idrol'],
            'foto' => $rutaFoto,
        ]);

        return response()->json(
            [
                'message' => 'Usuario registrado correctamente',
                'user' => $user,
            ],
            201,
        );
    }

    /**
     * @OA\Put(
     *     path="/api/usuarios/{idusuario}",
     *     summary="Actualizar un usuario (PUT)",
     *     description="Actualiza un usuario existente. Acepta JSON o multipart/form-data.",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         name="idusuario",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/UsuarioUpdateSchema")
     *         ),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UsuarioUpdateFormSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario actualizado con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/UsuarioSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado.")
     *         )
     *     )
     * )
     *
     * @OA\Post(
     *     path="/api/usuarios/{idusuario}",
     *     summary="Actualizar un usuario (POST)",
     *     description="Alternativa para actualizar un usuario si PUT no está disponible desde el cliente.",
     *     tags={"Usuarios"},
     *     @OA\Parameter(
     *         name="idusuario",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/UsuarioUpdateSchema")
     *         ),
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UsuarioUpdateFormSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario actualizado con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/UsuarioSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado.")
     *         )
     *     )
     * )
     */
    public function update(UpdateUsuarioRequest  $request, $idusuario): JsonResponse
    {
        $usuario = User::find($idusuario);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        // Auditoría del contexto
        AuditoriaService::setContextInfo('ActualizacionDeUsuario');

        // Validación de campos
        $validatedData = $request->validated();

        // Actualizar campos básicos
        $usuario->nombre = $validatedData['nombre'];
        $usuario->apellido = $validatedData['apellido'];
        $usuario->correo = $validatedData['correo'];
        $usuario->telefono = $validatedData['telefono'] ?? $usuario->telefono;
        $usuario->estado = $validatedData['estado'] ?? $usuario->estado;
        $usuario->idrol = $validatedData['idrol'];

        // Manejo de nueva contraseña (si fue enviada)
        if (!empty($validatedData['password'])) {
            $usuario->password = Hash::make($validatedData['password']);
        }

        // Cambiar foto si viene una nueva
        if (isset($validatedData['foto'])) {
            // Eliminar la anterior si no es la por defecto
            if ($usuario->foto && $usuario->foto !== 'fotos_usuarios/default.jpg') {
                Storage::disk('public')->delete($usuario->foto);
            }

            // Guardar nueva foto
            $rutaFoto = $validatedData['foto']->store('fotos_usuarios', 'public');
            $usuario->foto = $rutaFoto;
        }

        // Guardar cambios
        $usuario->save();

        return response()->json([
            'message' => 'Usuario actualizado con éxito.',
            'data' => $usuario
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios/app/select",
     *     tags={"Clientes"},
     *     summary="Obtiene la lista completa de usuarios para select",
     *     @OA\Response(
     *         response=200,
     *         description="Lista completa de usuarios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UsuarioSchema")
     *         )
     *     )
     * )
     */
    public function getUsuariosSelect(): JsonResponse
    {
        // Obtienes todos los usuarios activos ordenados por nombre
        $usuarios = User::select('id', 'nombre', 'apellido')
            ->where('estado', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        return response()->json($usuarios);
    }

    /**
     * @OA\Get(
     *     path="/api/usuariosExternos/app/select",
     *     tags={"Clientes"},
     *     summary="Obtiene la lista completa de usuarios para select",
     *     @OA\Response(
     *         response=200,
     *         description="Lista completa de usuarios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/UsuarioSchema")
     *         )
     *     )
     * )
     */
    public function getPersonalExternoSelect(): JsonResponse
    {
        // Obtienes todos los usuarios activos ordenados por nombre
        $usuarios = User::select('id', 'nombre', 'apellido')
            ->where('estado', 1)
            ->where('estado', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        return response()->json($usuarios);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión de usuario",
     *     description="Permite que un usuario inicie sesión con correo y contraseña. Devuelve un token y los datos del usuario si la autenticación es exitosa.",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"correo", "password"},
     *             @OA\Property(property="correo", type="string", format="email", example="admin@dominio.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Admin1234")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="token", type="string", example="1|abc123def456..."),
     *             @OA\Property(
     *                 property="usuario",
     *                 ref="#/components/schemas/UsuarioSchema"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Usuario sin rol asignado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario sin rol asignado")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'correo' => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Verifica que el usuario tenga un rol
            if (!$user->idrol || !$user->rol) {
                return response()->json(['message' => 'Usuario sin rol asignado'], 403);
            }

            // Cargar rol y sus permisos si vas a usarlos luego
            $user->load('rol.permisos');

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'usuario' => $user,
            ]);
        } catch (\Throwable $e) {
            // En producción podrías ocultar detalles
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión de usuario",
     *     description="Esta ruta permite que un usuario cierre sesión.",
     *     tags={"Usuarios"},
     *     @OA\Response(
     *         response=200,
     *         description="Cierre de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
