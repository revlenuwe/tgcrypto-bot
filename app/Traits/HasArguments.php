<?php


namespace App\Traits;


trait HasArguments
{
    protected $regex = "/\{([^\d]\w+?)\}/";

    public function checkArguments()
    {
        $matches = $this->extractVariableNames();

        if(array_diff($matches, array_keys($this->getArguments()))) {
            return $this->replyWithMessage([
                'text' => 'Some arguments are missing'
            ]);
        }

        return true;
    }

    protected function extractVariableNames() : array
    {
        preg_match_all($this->regex, $this->getPattern(), $matches);

        return $matches[1];
    }
}
