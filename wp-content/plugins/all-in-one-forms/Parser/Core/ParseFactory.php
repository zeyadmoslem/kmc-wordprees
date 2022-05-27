<?php

namespace rednaoeasycalculationforms\Parser\Core;

use Exception;
use rednaoeasycalculationforms\Parser\Elements\Math\ParseMathFunction;
use rednaoeasycalculationforms\Parser\Elements\Operations\Arithmetical\ParseArithmetical;
use rednaoeasycalculationforms\Parser\Elements\Operations\Logical\ParseComparator;
use rednaoeasycalculationforms\Parser\Elements\Operations\Logical\ParseCondition;
use rednaoeasycalculationforms\Parser\Elements\Operations\Logical\ParseConditionSentence;
use rednaoeasycalculationforms\Parser\Elements\Operations\Logical\ParseNegation;
use rednaoeasycalculationforms\Parser\Elements\ParseArray;
use rednaoeasycalculationforms\Parser\Elements\ParseBlock;
use rednaoeasycalculationforms\Parser\Elements\ParseDeclaration;
use rednaoeasycalculationforms\Parser\Elements\ParseParenthesis;
use rednaoeasycalculationforms\Parser\Elements\ParseReturn;
use rednaoeasycalculationforms\Parser\Elements\ParseSentence;
use rednaoeasycalculationforms\Parser\Elements\Scalars\ParseField;
use rednaoeasycalculationforms\Parser\Elements\Scalars\ParserBoolean;
use rednaoeasycalculationforms\Parser\Elements\Scalars\ParserNumber;
use rednaoeasycalculationforms\Parser\Elements\Scalars\ParserString;
use rednaoeasycalculationforms\Parser\Elements\Scalars\ParseVariable;

class ParseFactory {
    /**
     * @param $parent
     * @param $element
     * @return ParserElementBase
     */
    public static function GetParseElement($parent,$element)
    {
        if($element==null)
            return null;
        switch ($element->type) {
            case 'NUMBER':
                return new ParserNumber($parent,$element);
            case 'BOOLEAN':
                return new ParserBoolean($parent,$element);
            case 'STRING':
                return new ParserString($parent,$element);
            case 'MATH':
                return new ParseMathFunction($parent,$element);
            case 'MUL':
            case 'ADD':
            case 'SUB':
            case 'DIV':
                return new ParseArithmetical($parent,$element);
            case 'SENTENCE':
                return new ParseSentence($parent,$element);
            case 'P':
                return new ParseParenthesis($parent,$element);
            case 'CONDSENTENCE':
                return new ParseConditionSentence($parent,$element);
            case 'COMPARATOR':
                return new ParseComparator($parent,$element);
            case 'CONDITION':
                return new ParseCondition($parent,$element);
            case 'FIELD':
                return new ParseField($parent,$element);
            case 'ARR':
                return new ParseArray($parent,$element);
            case 'NEGATION':
                return new ParseNegation($parent,$element);
            case 'BLOCK':
                return new ParseBlock($parent,$element);
            case 'DECLARATION':
                return new ParseDeclaration($parent,$element);
            case 'RETURN':
                return new ParseReturn($parent,$element);
            case 'VARIABLE':
                return new ParseVariable($parent,$element);
            default:
                throw new Exception('Invalid token '.$element->type);



        }
    }
}