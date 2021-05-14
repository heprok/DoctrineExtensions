<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class Age extends FunctionNode
{
    public $dateSub = null;
    
    public $dateMinuend = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->dateMinuend = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->dateSub = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'AGE(' .
            $this->dateMinuend->dispatch($sqlWalker) . ', ' .
            $this->dateSub->dispatch($sqlWalker) .
        ')';
    }
}
