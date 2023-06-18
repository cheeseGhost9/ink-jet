function createCookieAzione(choise) {
    if(choise < 1 || choise > 3){
        choise = 1;
    }
    const d = new Date();
    //d.setTime(d.getTime() + (60*1000));
    //d.setTime(d.getTime() + (24*60*60*1000));
    d.setTime(d.getTime() + (60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = "azione=" + choise + ";" + expires + ";path=/";  
}