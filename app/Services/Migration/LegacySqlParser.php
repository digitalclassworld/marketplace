<?php

namespace App\Services\Migration;

class LegacySqlParser
{
    protected string $filePath;

    public function __construct(?string $filePath = null)
    {
        $this->filePath = $filePath ?: $this->resolveFilePath();
    }

    public function resolveFilePath(): string
    {
        $paths = [
            'C:\\Users\\meshw\\Downloads\\digitxix_elm.sql',
            'C:\\Users\\meshw\\Downloads\\digitix_elm.sql',
            base_path('digitxix_elm.sql'),
            base_path('digitix_elm.sql'),
        ];

        foreach ($paths as $p) {
            if (file_exists($p)) {
                return $p;
            }
        }

        throw new \RuntimeException("Legacy SQL file not found. Looked in: " . implode(', ', $paths));
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Extract column names from CREATE TABLE definition
     */
    public function getTableColumns(string $tableName): array
    {
        $handle = fopen($this->filePath, 'r');
        if (!$handle) {
            throw new \RuntimeException("Cannot open SQL file: {$this->filePath}");
        }

        $inTable = false;
        $columns = [];

        while (($line = fgets($handle)) !== false) {
            if (preg_match('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`?' . preg_quote($tableName, '/') . '`?\s*\(/i', $line)) {
                $inTable = true;
                continue;
            }

            if ($inTable) {
                if (preg_match('/^\s*\)\s*(ENGINE.*)?;$/i', $line)) {
                    break;
                }

                // Match column line: `column_name` type ...
                if (preg_match('/^\s*`([a-zA-Z0-9_]+)`\s+([a-zA-Z0-9_]+)/i', $line, $m)) {
                    $columns[] = $m[1];
                }
            }
        }

        fclose($handle);
        return $columns;
    }

    /**
     * Stream rows for a specific table yielding an associative array of [column => value]
     *
     * @param string $tableName
     * @param callable $callback function(array $row): void
     */
    public function streamTableRows(string $tableName, callable $callback): int
    {
        $handle = fopen($this->filePath, 'r');
        if (!$handle) {
            throw new \RuntimeException("Cannot open SQL file: {$this->filePath}");
        }

        $columns = [];
        $inInsert = false;
        $count = 0;
        $buffer = '';

        while (($line = fgets($handle)) !== false) {
            // Check for INSERT INTO `table` (`col1`, `col2`...) VALUES
            if (preg_match('/INSERT\s+INTO\s+`?' . preg_quote($tableName, '/') . '`?\s*\((.*?)\)\s*VALUES/i', $line, $matches)) {
                $rawCols = $matches[1];
                $columns = array_map(function ($c) {
                    return trim(trim($c), '`');
                }, explode(',', $rawCols));

                $inInsert = true;
                continue;
            }

            if ($inInsert) {
                $trimmed = trim($line);

                // If empty or comment or new statement, exit insert block
                if (empty($trimmed) || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '/*')) {
                    if (str_ends_with($trimmed, ';') || empty($trimmed)) {
                        $inInsert = false;
                    }
                    continue;
                }

                if (str_starts_with($trimmed, 'INSERT INTO') || str_starts_with($trimmed, 'CREATE TABLE')) {
                    $inInsert = false;
                    continue;
                }

                $buffer .= $line;

                // Check if buffer contains a complete tuple: (...), or (...);
                if (str_ends_with(rtrim($trimmed), ',') || str_ends_with(rtrim($trimmed), ';')) {
                    $isEnd = str_ends_with(rtrim($trimmed), ';');

                    // Parse tuples from buffer
                    $rows = $this->parseTuplesFromBuffer($buffer);
                    foreach ($rows as $rawValues) {
                        $row = [];
                        foreach ($columns as $idx => $colName) {
                            $row[$colName] = $rawValues[$idx] ?? null;
                        }
                        $callback($row);
                        $count++;
                    }

                    $buffer = '';
                    if ($isEnd) {
                        $inInsert = false;
                    }
                }
            }
        }

        fclose($handle);
        return $count;
    }

    /**
     * Parse raw SQL tuple string into array of parsed values
     */
    protected function parseTuplesFromBuffer(string $buffer): array
    {
        $results = [];
        $trimmed = trim($buffer);
        if (empty($trimmed)) return $results;

        // Split by line if each line starts with (
        $lines = explode("\n", $trimmed);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Remove trailing commas or semicolons
            $line = rtrim($line, ',;');
            if (str_starts_with($line, '(') && str_ends_with($line, ')')) {
                $inner = substr($line, 1, -1);
                $values = str_getcsv($inner, ',', "'", "\\");
                // Clean up NULLs and strings
                $cleaned = array_map(function ($v) {
                    if ($v === 'NULL' || $v === null) return null;
                    return $v;
                }, $values);
                $results[] = $cleaned;
            }
        }

        return $results;
    }
}
