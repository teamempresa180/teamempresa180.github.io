$ErrorActionPreference = "Stop"
$logPath = "C:\Users\lizar\.gemini\antigravity\brain\d888ee7a-c576-411c-bf0a-5b3b66c9f1f6\.system_generated\logs\transcript.jsonl"

$lines = Get-Content $logPath
foreach ($line in $lines) {
    if ($line -match '"tool_name":"view_file"') {
        # Check if it's a response
        if ($line -match '"type":"TOOL_RESPONSE"') {
            $json = $line | ConvertFrom-Json
            if ($json.tool_calls -and $json.tool_calls.Count -gt 0) {
                $output = $json.tool_calls[0].response.output
                
                # check which file it was
                $filePath = $null
                if ($output -match 'File Path: `file:///(.*?)`') {
                    $filePath = $matches[1]
                }
                
                if ($filePath) {
                    $filePath = $filePath.Replace("%20", " ").Replace("%C2%B0", "°")
                    # only process if it's one of the 3 index files
                    if ($filePath -match "download/index.html" -or $filePath -match "download/SITIO.*index.html") {
                        Write-Host "Restoring $filePath"
                        $outLines = @()
                        $outputLines = $output -split "`n"
                        foreach ($ol in $outputLines) {
                            if ($ol -match "^(\d+): (.*)") {
                                $outLines += $matches[2]
                            } elseif ($ol -match "^(\d+):$") {
                                $outLines += ""
                            }
                        }
                        
                        if ($outLines.Count -gt 100) {
                            # It's the full file (or 440 lines)
                            [IO.File]::WriteAllLines($filePath, $outLines, [Text.Encoding]::UTF8)
                        }
                    }
                }
            }
        }
    }
}
Write-Host "Done restoring."
