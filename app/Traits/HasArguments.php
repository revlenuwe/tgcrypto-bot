<?php


namespace App\Traits;


trait HasArguments
{
    protected $regex = "/\{([^\d]\w+?)\}/";

    public function checkArguments() : bool
    {
        $matches = $this->extractVariableNames();

        if(array_diff($matches, array_keys($this->getArguments()))) {
            return false;
        }

        return true;
    }

    protected function extractVariableNames() : array
    {
        preg_match_all($this->regex, $this->getPattern(), $matches);

        return $matches[1];
    }
}
