<?php


namespace Flamingo\Console\Commands;


class LogsHandler extends Handler
{
    public function load()
    {
        print $this->console->out('Logs:', 'yellow');
        // Get logs
        $logs = glob('logs/*.log');
        // Print out all logs
        if (empty($logs)) {
            print $this->console->out("  No logs found.", 'red');
        } else {
            foreach ($logs as $log) {
                $log = pathinfo($log, PATHINFO_BASENAME);
                print $this->console->out("  {$log}", 'green');
            }
        }

        print (
            $this->console->newLine()
            .$this->console->out('You can print a log by a date using: ', 'yellow')
            .$this->console->inline('  php flame log [date]', 'blue')
            .$this->console->out(' [date]=YYYY_MM_DD')
        );
    }

    /**
     * Load only one specified log
     *
     * @param array $argv Date
     * @return int|void
     */
    public function loadOne($argv)
    {
        $date = $argv[0];

        // Get logs
        $logs = glob('logs/*.log');
        $findByDate = $date . "_trace.log";
        // Find log by date
        foreach ($logs as $log) {
            // Get file basename
            $log = pathinfo($log, PATHINFO_BASENAME);
            if ($log == $findByDate) {
                // Get target file
                $target = file_get_contents('logs/' . $log);
                print $this->console->out("Log from ${date}:", 'yellow');
                // Print each line
                return $this->printLines($target);
            }
        }

        return print $this->console->out("Log '{$date}' not found.", 'red');
    }

    /**
     * Edit syntax high-lightning for output
     *
     * @param $target
     */
    private function printLines($target)
    {
        // Available log prefixes
        $prefixes = [
            'WARN' => 'yellow',
            'ERROR' => 'red',
            'SUCCESS' => 'green',
            'INFO' => 'blue'
        ];

        // Syntax set status
        $syntaxSet = 0;

        // Get line by line
        $lines = explode("\n", $target);

        // Loop through lines
        foreach ($lines as $line) {
            // Get log type
            $logType = explode(' ', trim($line))[0];
            // Set log type and print out the message
            foreach ($prefixes as $key => $color) {
                if ($logType === $key) {
                    //print "true\t";
                    print $this->console->out('  ' . $line, $color);
                    $syntaxSet = 1;
                    break;
                }
            }
            if ($syntaxSet--) continue;
            print $this->console->out('  ' . $line);
        }
    }
}