
// profilo utente
function createUserProfile(user, n_post, n_follows, n_followers, you_follow, current_user){
    let result = "";
    result += `
            <div class="row">
                <div class="user col-10 offset-1 col-md-7 mt-2">
                    <h2 class="text-center">Profilo utente</h2>
                    <table class=table">
                        <tr>
                            <td scope="col"><a href="${user.img_utente}"><img src="${user.img_utente}" alt="img profilo" /></a></td>
                            <td scope="col"colspan="2">Nome: ${user.nome_utente}<br>Data di nascita: ${user.data_nascita}</td>
                        </tr>
                        <tr>
                            <td scope="col"><button class="user_button btn text-center" onclick="showData(1)">Post => ${n_post}</button></td>
                            <td scope="col"><button class="user_button btn text-center" onclick="showData(2)">Follows => ${n_follows}</button></td>
                            <td scope="col"><button class="user_button btn text-center" onclick="showData(3)">Followers => ${n_followers}</button></td>
                        </tr>
                    </table>`;
    if(current_user){
        result += `
                    <a href="impostazioni.php?action=1" class="btn text-center" style="margin-left: 15%;">CAMBIA DATI PROFILO</a>
                    <a href="impostazioni.php?action=2" class="btn text-center" style="margin-left: 15%;">CAMBIA PASSWORD</a>`;
    } else {
        result += ` <button id="button_follow" class="button_follow btn" onclick="updateFollow()" style="margin-left: 15%;">`;
        if(you_follow === true){
            result += `NON SEGUIRE`;
        } else {
            result += `SEGUI`;
        }
        result += `</button>`;
    }
    result += `
                </div>
                <div class="user_data" style="display: none">
                </div>
            </div>
    `;
    return result;
}

// mostra i dati quali post, follow e follower
function showData(choise){
    let print = "";
    let section = document.querySelector(".user_data");
    section.style.display = "";

    switch(choise){
        case 1:
            if(button_value != 1){
                section.innerHTML = "";
            }
            button_value = 1;
            if(post_tot === 0){
                print = `<div class="row">
                            <div class="user col-10 offset-1 col-md-7 mt-2">
                                <p>Non ci sono post al momento.</p>
                            </div>
                        </div>`;
                section.innerHTML = print;
            } else {
                axios.get('api-post.php', {params: { id: id, source: "profile" }}).then(response => {
                    print = printPosts(response.data.post, response.data.owner);
                    section.innerHTML += print;
                });
            }
            break;

        case 2:
            if(button_value != 2){
                section.innerHTML = "";
            }
            button_value = 2;
            if(follows_tot === 0){
                print = `<div class="row">
                            <div class="user col-10 offset-1 col-md-7 mt-2">
                                <p>Non ha follow.</p>
                            </div>
                        </div>`;
                section.innerHTML = print;
            } else {
                axios.get('api-follow.php', {params: { id: id, choise: "s" }}).then(response => {
                    print = printPeople(response.data.list, response.data.follows_list, response.data.id_utente);
                    section.innerHTML = print;
                });
            }
            break;

        case 3:
            if(button_value != 3){
                section.innerHTML = "";
            }
            button_value = 3;
            if(followers_tot === 0){
                print = `<div class="row">
                            <div class="user col-10 offset-1 col-md-7 mt-2">
                                <p>Non ci sono followers.</p>
                            </div>
                        </div>`;
                section.innerHTML = print;
            } else {
                axios.get('api-follow.php', {params: { id: id, choise: "ers" }}).then(response => {
                    print = printPeople(response.data.list, response.data.follows_list, response.data.id_utente);
                    section.innerHTML = print;
                });
            }
            break;

        default:
            button_value = 0;
            section.style.display = "none";
    }
}

// stampa i post dell'utente
function printPosts(post_list, owner){
    let result = "";
    console.log(post_list);
    for(let i = 0; i < post_list.length; i++){
        result += `
                <div class="row">
                    <div class="post col-10 offset-1 col-md-7 mt-2">
                        <article id="${post_list[i].id_post}">
                            <header>
                                <p>${post_list[i].data_post}</p>
                            </header>
                            <section>
        `;
        if (post_list[i].img_post !== undefined && post_list[i].img_post !== null && post_list[i].img_post !== ""){
            result += `
                                <div>
                                    <a href="${post_list[i].img_post}"><img src="${post_list[i].img_post}" alt="img_post" /></a>
                                </div>
            `;
        }
        if (post_list[i].testo_post !== undefined && post_list[i].testo_post !== null && post_list[i].testo_post !== ""){
            result += `
                                <p class="post_text text-justify">${post_list[i].testo_post}</p>
            `;
        }
        result +=`
                            </section>
                            <footer>
                                <a href="post.php?post=${post_list[i].id_post}" class="btn">Commenti</a>
                            `
        if(owner){
            result +=`
                                <a href="gestisci-post.php?id=${post_list[i].id_post}" onclick="createCookieAzione(2)" class="btn">MODIFICA</a>
                                <a href="gestisci-post.php?id=${post_list[i].id_post}" onclick="createCookieAzione(3)" class="btn">ELIMINA</a>
                    `;
        }
        result +=`
                            </footer>
                        </article>
                    </div>
                </div>
        `;
    }
    return result;
}

// stampa la lista di follows o followers
function printPeople(people_list, followed_list, own_id){
    let result = "";
    for(let i = 0; i < people_list.length; i++){
        result += `
                <div class="row mb-4">
                    <div class="col-1"></div>
                    <div class="img_utente col-3 col-md-2 mt-2">
                        <a href="profilo.php?id=${people_list[i].id_utente}"><img style="height: 80px;" src="${people_list[i].img_utente}" alt="img_utente" /></a>
                    </div>
                    <div class="nome_utente col-2 col-md-2 mt-2">
                        <a href="profilo.php?id=${people_list[i].id_utente}" class="btn">${people_list[i].nome_utente}</a>
                    </div>`;
        if(people_list[i].id_utente !== own_id){
            result +=`
                    <button id="${people_list[i].id_utente}" value="${people_list[i].id_utente}" onclick="updateFollow(${people_list[i].id_utente})" class="btn col-3 col-md-2 mt-2">`;
            if(checkFollow(people_list[i], followed_list)){
                result += `NON SEGUIRE`;
            } else {
                result += `SEGUI`;
            }
            result +=`
                    </button>
            `;
        }
        result += `
                </div>`;
    }
    return result;
}

// aggiorna il follow
function updateFollow(id_utente){
    if(id_utente == undefined){
        let azione = document.getElementsByClassName("button_follow")[0];
        axios.get('api-aggiorna-follow.php', {params: { id: id }}).then(response => {
            if(response.data.you_follow === true){
                azione.innerHTML = "NON SEGUIRE";
            } else {
                azione.innerHTML = "SEGUI";
            }
        });
    } else {
        let azione = document.getElementById(id_utente);
        axios.get('api-aggiorna-follow.php', {params: { id_utente: id_utente }}).then(response => {
            if(response.data.you_follow === true){
                azione.innerHTML = "NON SEGUIRE";
            } else {
                azione.innerHTML = "SEGUI";
            }
        });
    }    
}

// controlla il follow
function checkFollow(user, followed_list){
    value = followed_list.find(elem => elem.id_utente === user.id_utente);
    if(value !== undefined){
        return true;
    } else {
        return false;
    }
}



const urlParams = new URLSearchParams(location.search);
const id = urlParams.get("id");

// utente corrente
let current_user;

let button_value;
let post_tot;
let follows_tot;
let followers_tot;

axios.get('api-profilo.php', {params: { id: id }}).then(response => {
    let user_profile = "";
    let main = document.querySelector(".main");

    const user_data = response.data.user_data[0];

    if(user_data !== undefined){
        current_user = response.data.current_user;
        post_tot = response.data.post;
        follows_tot = response.data.follows;
        followers_tot = response.data.followers;
        user_profile = createUserProfile(user_data, post_tot, follows_tot, followers_tot, response.data.you_follow, current_user);
    } else {
        user_profile = `<div class="row">
                            <div class="user col-10 offset-1 col-md-7 mt-2">
                                <p>L'utente non esiste.</p>
                            </div>
                        </div>`;
    }

    main.innerHTML += user_profile;
});

