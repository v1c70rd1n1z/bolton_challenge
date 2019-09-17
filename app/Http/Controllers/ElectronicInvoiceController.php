<?php


namespace App\Http\Controllers;

use App\Exceptions\ApiClientArquiveiEnvironmentVariableMissingException;
use App\Exceptions\ApiClientArquiveiException;
use App\Exceptions\ApiClientArquiveiResponseStructureException;
use App\Exceptions\ElectronicInvoiceListsException;
use App\Exceptions\ElectronicInvoiceSaveResponseException;
use App\Exceptions\ElectronicInvoiceShowException;
use App\Services\ElectronicInvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

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
     *     @OA\Response(
     *         response="500",
     *         description="One of ArquiveiApi environment variables is missing."
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Something went wrong on ApiClientArquivei."
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Something went wrong when trying to parse the structure. Something went wrong when trying to save Electronic Invoice."
     *     ),
     * )
     * @return Response|ResponseFactory
     * @throws ApiClientArquiveiEnvironmentVariableMissingException
     * @throws ApiClientArquiveiException
     * @throws ApiClientArquiveiResponseStructureException
     * @throws ElectronicInvoiceSaveResponseException
     */
    public function receive()
    {
        $this->electronicInvoiceService->receive();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     *     path="/nfe",
     *     operationId="/nfe",
     *     tags={"NFe - List"},
     *     @OA\Response(
     *         response="200",
     *         description="Retrieves the imported keys"
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Something went wrong when trying to parse Electronic Invoice list."
     *     ),
     * )
     * @return Response|ResponseFactory
     * @throws ElectronicInvoiceListsException
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
     *     @OA\Response(
     *         response="500",
     *         description="Something went wrong when trying to to get an specific Electronic Invoice Response by a given key."
     *     ),
     * )
     * @param $key
     * @return JsonResponse
     * @throws ElectronicInvoiceShowException
     */
    public function show($key)
    {
        $response = $this->electronicInvoiceService->show($key);

        return response()->json($response->toArray());
    }
}
