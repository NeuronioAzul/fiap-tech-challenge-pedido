<?php

namespace TechChallenge\Api\Customer;

use TechChallenge\Api\Controller;
use Illuminate\Http\Request;
use Throwable;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;
use TechChallenge\Adapters\Controllers\Customer\Show as ControllerCustomerShow;
use TechChallenge\Adapters\Controllers\Customer\ShowByCpf as ControllerCustomerShowByCpf;

class Customer extends Controller
{
    public function show(Request $request, string $id)
    {
        try {
            $result = (new ControllerCustomerShow($this->AbstractFactoryRepository))->execute($id);

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
    public function showByCfp(Request $request, string $cpf)
    {
        try {
            $result = (new ControllerCustomerShowByCpf($this->AbstractFactoryRepository))->execute($cpf);

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
        } catch (\Throwable $e) {
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
