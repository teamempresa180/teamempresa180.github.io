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


# 2. Agencia Digital
Write-Host "Processing Agencia Digital..."
$BaseDir2 = (Resolve-Path "c:\Users\lizar\Desktop\download\SITIO GRUPO AGENCIA DIGITAL 180*").Path
$File2 = Join-Path $BaseDir2 "index.html"
$Orig2 = [IO.File]::ReadAllText($File2)

$NavReps2 = @{
    '<a href="#nosotros" class="nav-link">Nosotros</a>' = '<a href="nosotros.html" class="nav-link">Nosotros</a>';
    '<a href="#servicios" class="nav-link">Servicios</a>' = '<a href="servicios.html" class="nav-link">Servicios</a>';
    '<a href="#proceso" class="nav-link">Proceso</a>' = '<a href="proceso.html" class="nav-link">Proceso</a>';
    '<a href="#contacto" class="nav-link cta-nav">Contacto</a>' = '<a href="contacto.html" class="nav-link cta-nav">Contacto</a>';
    'href="#nosotros"' = 'href="nosotros.html"';
    'href="#servicios"' = 'href="servicios.html"';
    'href="#proceso"' = 'href="proceso.html"';
    'href="#contacto"' = 'href="contacto.html"'
}

$P_Inicio2 = '<section id="inicio".*?</section>'
$P_Marquee2 = '<div class="marquee-container">.*?</div>'
$P_Nosotros2 = '<section id="nosotros".*?</section>'
$P_Servicios2 = '<section id="servicios".*?</section>'
$P_Proceso2 = '<section id="proceso".*?</section>'
$P_Contacto2 = '<section id="contacto" class="cta-section">.*?</section>'

$C_Index2 = Process-Site -Content $Orig2 -NavReplacements $NavReps2 -SectionsToRemove @{ $P_Nosotros2=$true; $P_Servicios2=$true; $P_Proceso2=$true; $P_Contacto2=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir2 "index.html"), $C_Index2)

$C_Nosotros2 = Process-Site -Content $Orig2 -NavReplacements $NavReps2 -SectionsToRemove @{ $P_Inicio2=$true; $P_Marquee2=$true; $P_Servicios2=$true; $P_Proceso2=$true; $P_Contacto2=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir2 "nosotros.html"), $C_Nosotros2)

$C_Servicios2 = Process-Site -Content $Orig2 -NavReplacements $NavReps2 -SectionsToRemove @{ $P_Inicio2=$true; $P_Marquee2=$true; $P_Nosotros2=$true; $P_Proceso2=$true; $P_Contacto2=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir2 "servicios.html"), $C_Servicios2)

$C_Proceso2 = Process-Site -Content $Orig2 -NavReplacements $NavReps2 -SectionsToRemove @{ $P_Inicio2=$true; $P_Marquee2=$true; $P_Nosotros2=$true; $P_Servicios2=$true; $P_Contacto2=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir2 "proceso.html"), $C_Proceso2)

$C_Contacto2 = Process-Site -Content $Orig2 -NavReplacements $NavReps2 -SectionsToRemove @{ $P_Inicio2=$true; $P_Marquee2=$true; $P_Nosotros2=$true; $P_Servicios2=$true; $P_Proceso2=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir2 "contacto.html"), $C_Contacto2)


# 3. Software Studio
Write-Host "Processing Software Studio..."
$BaseDir3 = (Resolve-Path "c:\Users\lizar\Desktop\download\SITIO SOFTWARE STUDIO 180*").Path
$File3 = Join-Path $BaseDir3 "index.html"
$Orig3 = [IO.File]::ReadAllText($File3)

$NavReps3 = @{
    '<a href="#servicios" class="nav-link">Servicio</a>' = '<a href="servicios.html" class="nav-link">Servicio</a>';
    '<a href="#proceso" class="nav-link">Proceso</a>' = '<a href="proceso.html" class="nav-link">Proceso</a>';
    '<a href="#tecnologias" class="nav-link">Tecnologías</a>' = '<a href="tecnologias.html" class="nav-link">Tecnologías</a>';
    '<a href="#contacto" class="nav-link cta-nav">Contacto</a>' = '<a href="contacto.html" class="nav-link cta-nav">Contacto</a>';
    'href="#inicio"' = 'href="index.html"';
    'href="#servicios"' = 'href="servicios.html"';
    'href="#proceso"' = 'href="proceso.html"';
    'href="#tecnologias"' = 'href="tecnologias.html"';
    'href="#contacto"' = 'href="contacto.html"'
}

$P_Inicio3 = '<section id="inicio".*?</section>'
$P_Servicios3 = '<section id="servicios".*?</section>'
$P_Proceso3 = '<section id="proceso".*?</section>'
$P_Tecnologias3 = '<section id="tecnologias".*?</section>'
$P_Contacto3 = '<section id="contacto" class="cta-section">.*?</section>'

$C_Index3 = Process-Site -Content $Orig3 -NavReplacements $NavReps3 -SectionsToRemove @{ $P_Servicios3=$true; $P_Proceso3=$true; $P_Tecnologias3=$true; $P_Contacto3=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir3 "index.html"), $C_Index3)

$C_Servicios3 = Process-Site -Content $Orig3 -NavReplacements $NavReps3 -SectionsToRemove @{ $P_Inicio3=$true; $P_Proceso3=$true; $P_Tecnologias3=$true; $P_Contacto3=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir3 "servicios.html"), $C_Servicios3)

$C_Proceso3 = Process-Site -Content $Orig3 -NavReplacements $NavReps3 -SectionsToRemove @{ $P_Inicio3=$true; $P_Servicios3=$true; $P_Tecnologias3=$true; $P_Contacto3=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir3 "proceso.html"), $C_Proceso3)

$C_Tecnologias3 = Process-Site -Content $Orig3 -NavReplacements $NavReps3 -SectionsToRemove @{ $P_Inicio3=$true; $P_Servicios3=$true; $P_Proceso3=$true; $P_Contacto3=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir3 "tecnologias.html"), $C_Tecnologias3)

$C_Contacto3 = Process-Site -Content $Orig3 -NavReplacements $NavReps3 -SectionsToRemove @{ $P_Inicio3=$true; $P_Servicios3=$true; $P_Proceso3=$true; $P_Tecnologias3=$true }
[IO.File]::WriteAllText((Join-Path $BaseDir3 "contacto.html"), $C_Contacto3)

Write-Host "Done."
