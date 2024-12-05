<?php

namespace TechChallenge\Api\Product;

use Illuminate\Http\Request;
use TechChallenge\Api\Controller;
use TechChallenge\Adapters\Controllers\Product\Index as ControllerProductIndex;
use TechChallenge\Adapters\Controllers\Product\Show as ControllerProductShow;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;
use Throwable;

class Product extends Controller
{
    public function index(Request $request)
    {
        try {
            $results = (new ControllerProductIndex($this->AbstractFactoryRepository))
                ->execute([
                    "page" => $request->get('page'),
                    "per_page" => $request->get('per_page')
                ]);

            return $this->return($results, 200);
        } catch (DefaultException $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                $e->getStatus()
            );
        } catch (Throwable $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                400
            );
        }
    }

    public function show(string $id)
    {
        try {
            $result = (new ControllerProductShow($this->AbstractFactoryRepository))->execute($id);

            return $this->return($result, 200);
        } catch (DefaultException $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                $e->getStatus()
            );
        } catch (Throwable $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                400
            );
        }
    }
}
