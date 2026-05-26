$ErrorActionPreference = "Stop"

function Process-Site {
    param (
        [string]$Content,
        [hashtable]$NavReplacements,
        [hashtable]$SectionsToRemove
    )

    $NewContent = $Content

    foreach ($Old in $NavReplacements.Keys) {
        $New = $NavReplacements[$Old]
        $NewContent = $NewContent.Replace($Old, $New)
    }

    foreach ($Regex in $SectionsToRemove.Keys) {
        if ($SectionsToRemove[$Regex] -eq $true) {
            $NewContent = [Regex]::Replace($NewContent, $Regex, "", [System.Text.RegularExpressions.RegexOptions]::Singleline)
        }
    }

    return $NewContent
}

# 1. Grupo Empresarial
Write-Host "Processing Grupo Empresarial..."
$BaseDir1 = "c:\Users\lizar\Desktop\download"
$File1 = Join-Path $BaseDir1 "index.html"
$Orig1 = [IO.File]::ReadAllText($File1)

$NavReps1 = @{
    '<a href="#inicio">Inicio</a>' = '<a href="index.html">Inicio</a>';
    '<a href="#unidades-de-negocio">Unidades de negocio</a>' = '<a href="unidades.html">Unidades de negocio</a>';
    '<a href="#nosotros">Nosotros</a>' = '<a href="nosotros.html">Nosotros</a>';
    '<a href="#contacto">Contáctenos</a>' = '<a href="contacto.html">Contáctenos</a>';
    'href="#unidades-de-negocio"' = 'href="unidades.html"';
    'href="#contacto"' = 'href="contacto.html"'
}

$P_Inicio1 = '<section id="inicio".*?</section>'
$P_Unidades1 = '<section id="unidades-de-negocio".*?</section>'
$P_Nosotros1 = '<section id="nosotros".*?</section>\s*<section class="testimonial-section.*?</section>'
$P_Cta1 = '<div style="text-align: center; padding: 20px 40px 80px; display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">.*?</div>'

$C_Index1 = Process-Site -Content $Orig1 -NavReplacements $NavReps1 -SectionsToRemove @{ $P_Unidades1=$true; $P_Nosotros1=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir1 "index.html"), $C_Index1)

$C_Unidades1 = Process-Site -Content $Orig1 -NavReplacements $NavReps1 -SectionsToRemove @{ $P_Inicio1=$true; $P_Nosotros1=$true; $P_Cta1=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir1 "unidades.html"), $C_Unidades1)

$C_Nosotros1 = Process-Site -Content $Orig1 -NavReplacements $NavReps1 -SectionsToRemove @{ $P_Inicio1=$true; $P_Unidades1=$true; $P_Cta1=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir1 "nosotros.html"), $C_Nosotros1)

$C_Contacto1 = Process-Site -Content $Orig1 -NavReplacements $NavReps1 -SectionsToRemove @{ $P_Inicio1=$true; $P_Unidades1=$true; $P_Nosotros1=$true; $P_Cta1=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir1 "contacto.html"), $C_Contacto1)

Write-Host "Done."
