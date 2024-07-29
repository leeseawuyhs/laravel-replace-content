<?php

namespace ReplaceContent;

use Illuminate\Support\Facades\DB;

class ReplaceContent
{
    private $tablesAndColumnsToUpdate;
    private $replacements;

    public function __construct(array $tablesAndColumnsToUpdate, array $replacements)
    {
        $this->tablesAndColumnsToUpdate = $tablesAndColumnsToUpdate;
        $this->replacements = $replacements;
    }

    public function updateColumns()
    {
        foreach ($this->tablesAndColumnsToUpdate as $table => $columns) {
            foreach ($columns as $column) {
                $rawQuery = $this->buildReplaceContent($column, $this->replacements);
                DB::table($table)->update([$column => DB::raw($rawQuery)]);
            }
        }
    }

    private function buildReplaceContent(string $content, array $replacements): string
    {
        foreach ($replacements as $search => $replace) {
            $content = "REPLACE($content, '$search', '$replace')";
        }

        return $content;
    }
}
