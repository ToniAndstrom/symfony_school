<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController


{
    #[Route("/", name: "calculator_page")]

    public function calculator(Request $request): Response
    {
        $number1 = $request->query->get("number1", "");
        $number2 = $request->query->get("number2", "");
        $operation = $request->query->get("operation", "");
        $clear = $request->query->get("clear", "");


        $value = "";

        if ($clear) {
            $number1 = "";
            $number2 = "";
            $operation = "";
            $value = "0";
        } else {
            switch ($operation) {
                case "add":
                    if ($number1 == 0 && $number2 == 0) {
                        $value = "zero";
                    } else
                        $value = $number1 + $number2;
                    break;
                case "subtract":
                    if ($number1 == 0 && $number2 == 0) {
                        $value = "zero";
                    } else
                        $value = $number1 - $number2;
                    break;
                case "multiply":
                    if ($number1 == 0 || $number2 == 0) {
                        $value = "zero";
                    } else
                        $value = $number1 * $number2;

                    break;
                case "divide":
                    if ($number1 == 0 || $number2 == 0) {
                        $value = "Cannot divide by zero";
                    } else
                        $value = $number1 / $number2;

                    break;
            }
        }



        return $this->render(
            "calculator/index.html.twig",
            ["number1" => $number1, "number2" => $number2, "operation" => $operation, "value" => $value]


        );
    }
}
