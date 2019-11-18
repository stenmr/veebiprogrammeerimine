window.onload = function() {
    document.getElementById("submitPic").disabled = true;
    document.getElementById("fileToUpload").addEventListener("change", checkSize);
}

function checkSize() {
    if (document.getElementById("fileToUpload").files[0].size <= 2500000) {
        document.getElementById("submitPic").disabled = false;
        document.getElementById("notice").innerHTML = "";
    } else {
        document.getElementById("submitPic").disabled = true;
        document.getElementById("notice").innerHTML = "Fail on jõhkralt suur";
    }
}