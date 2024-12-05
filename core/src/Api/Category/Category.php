<?php

namespace TechChallenge\Api\Category;

use TechChallenge\Api\Controller;
use Illuminate\Http\Request;
use Throwable;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;
use TechChallenge\Adapters\Controllers\Category\Index as ControllerCategoryIndex;
use TechChallenge\Adapters\Controllers\Category\Show as ControllerCategoryShow;

class Category extends Controller
{
    public function index(Request $request)
    {
        try {
            $results = (new ControllerCategoryIndex($this->AbstractFactoryRepository))->execute([
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

    public function show(Request $request, string $id)
    {
        try {
            $result = (new ControllerCategoryShow($this->AbstractFactoryRepository))->execute($id);

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
