<?php


namespace App\Http\Controllers;

use App\Services\ElectronicInvoiceService;
use Illuminate\Http\Response;

class ElectronicInvoiceController
{

    private $electronicInvoiceService;

    public function __construct(ElectronicInvoiceService $electronicInvoiceService)
    {
        $this->electronicInvoiceService = $electronicInvoiceService;
    }

    /**
     * @OA\Post(
     *     path="/nfe/receive",
     *     operationId="/nfe/receive",
     *     tags={"NFe - Receive"},
     *     @OA\Response(
     *         response="204",
     *         description="All NFes were successfully imported"
     *     ),
     * )
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \App\Exceptions\ApiClientArquiveiEnvironmentVariableMissingException
     * @throws \App\Exceptions\ApiClientArquiveiException
     * @throws \App\Exceptions\ApiClientArquiveiResponseStructureException
     * @throws \Nathanmac\Utilities\Parser\Exceptions\ParserException
     */
    public function receive()
    {
        $this->electronicInvoiceService->receive();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @OA\Get(
     *     path="/nfe",
     *     operationId="/nfe",
     *     tags={"NFe - List"},
     *     @OA\Response(
     *         response="200",
     *         description="Retrieves the imported keys"
     *     ),
     * )
     * @return Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function lists()
    {
        $response = $this->electronicInvoiceService->lists();

        return response($response);
    }

    /**
     * @OA\Get(
     *     path="/nfe/{key}",
     *     operationId="/nfe/key",
     *     tags={"NFe - Show"},
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="Imported key",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Retrieves the imported keys"
     *     ),
     * )
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($key)
    {
        $response = $this->electronicInvoiceService->show($key);

        return response()->json($response->toArray());
    }
}
