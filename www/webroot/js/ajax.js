window.onload(forNewDom('news', '1'));

// Если loyout_flag = 0 - загружаем весь контект, если 1 - только контент
function forNewDom(path, loyout_flag = '0'){
        loyout_flag='loyout_flag='+loyout_flag;
        request = new AjaxRequest();
        request.open("POST", "/admin/"+path, true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.setRequestHeader("Content-length", loyout_flag.length);
        request.setRequestHeader("Connection", "close");
        request.onreadystatechange = function()
        {
            if (this.readyState == 4)
            {
                if (this.status == 200)
                {
                    if (this.responseText != null)
                    {
                        document.getElementById('content').innerHTML = this.responseText;
                    }
                    else alert("Ошибка AJAX: Данные не получены");
                }
                else alert( "Ошибка AJAX: " + this.statusText);
            }
        };
        request.send(loyout_flag);
}

function AjaxRequest()
{
    try
    {
        var request = new XMLHttpRequest();
    }
    catch(e1)
    {
        try
        {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e2)
        {
            try
            {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e3)
            {
                request = false;
            }
        }
    }
    return request;
}

