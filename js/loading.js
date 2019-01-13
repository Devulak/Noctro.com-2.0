var totalFiles = 0;

/* file loading progress percentage */
function UpdatePercentage(needed)
{
    var percentage = isNaN(totalFiles) ? 'N/A' : (totalFiles - needed) / totalFiles * 100;

    document.getElementById("Bar").style.width = percentage + "%";
    document.getElementById("Percentage").innerHTML = Math.round(percentage);
}

/**
 * gmod called functions
 */
function GameDetails(servername, serverurl, mapname, maxplayers, steamid, gamemode)
{
    document.getElementById("Gamemode").innerHTML = gamemode;
    document.getElementById("Map").innerHTML = mapname;
}

function DownloadingFile(fileName)
{
    document.getElementById("BarInfo").innerHTML = "Downloading " + fileName;
}

function SetFilesTotal(total)
{
    document.getElementById("FilesTotal").innerHTML = total;
    totalFiles = total;
}

function SetFilesNeeded(needed)
{
    var needed = parseInt(needed);
    document.getElementById("FilesLoaded").innerHTML = totalFiles - needed;
    UpdatePercentage(needed);
}

function SetStatusChanged(status)
{
    document.getElementById("BarInfo").innerHTML = "";
    document.getElementById("DownloadDescription").innerHTML = status;
    document.getElementById("FilesLoaded").innerHTML = totalFiles;
    UpdatePercentage(0);
}










// Debug purpose
window.addEventListener("load", function () {

    return; // Out comment to debug

    if (window.location.search.substr(1)) return;
    GameDetails( 'Testserver', 'http://localhost/index.html', 'cs_office', 14, 76561198051267973, 'prophunt' );

    var demofiles = [
        'materials/models/prophunt/car.mdl',
        'materials/models/prophunt/car2.mdl',
        'materials/models/prophunt/eggtimer.mdl',
        'materials/models/prophunt/bottle.mdl',
        'materials/models/prophunt/bottle2.mdl',
        'materials/models/prophunt/gastank.mdl',
        'materials/models/prophunt/camera.mdl',
        'materials/models/prophunt/something.mdl',
        'materials/models/prophunt/table.mdl',
        'materials/models/prophunt/chair.mdl',
        'materials/models/prophunt/chair2.mdl',
        'materials/models/prophunt/chair3.mdl',
        'materials/models/prophunt/bin.mdl',
        'materials/models/prophunt/tire.mdl',
        'materials/models/prophunt/tire2.mdl',
        'materials/models/prophunt/key.mdl',
        'materials/models/prophunt/door.mdl',
        'materials/models/prophunt/door2.mdl',
    ];

    SetStatusChanged( 'Downloading some demo files...' );
    SetFilesTotal( demofiles.length );
    var index = 0;

    function Update()
    {
        DownloadingFile( demofiles[index] );
        SetFilesNeeded( demofiles.length - index );
        index++;
        if (index > demofiles.length)
        {
            SetStatusChanged("Sending client info...");
            return;
        }
        setTimeout(Update, Math.random()*500);
    }
    Update();
});