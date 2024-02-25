<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        $title = $exception->getMessage();
        // $errors = [];
        
        // foreach($exception->errors() as $field => $menssage){
        //     $pointer = "/" . str_replace('.' , '/' , $field);

        //     $errors[] = [
        //         'title' => $title,
        //         'details' => $menssage[0],
        //         'source' => [
        //             'pointer' => $pointer
        //         ]
        //     ];
        // };
        // return response()->json([
        //     'errors' => $errors
        // ], 422);
        return response()->json([
            'errors' => collect($exception->errors())
                ->map(function($messages, $field) use ($title) {
                    return [
                        'title' => $title,
                        'detail' => $messages[0],
                        'source' => [
                            'pointer' => "/".str_replace('.', '/', $field)
                        ]
                    ];
                })->values()
        ], 422);
    }
}
