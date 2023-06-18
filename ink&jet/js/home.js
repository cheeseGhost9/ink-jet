
// stampa i post degli utenti seguiti
function printFollowedUsersPosts(post){
    let result = "";

    for(let i = 0; i < post.length; i++){
        result += `
        <div class="row">
            <div class="col-10 offset-1 col-md-7 mt-2 post">
                <article>
                    <header>
                        <div class="row mb-2">
                            <a href="profilo.php?id=${post[i].id_utente}" class="col-2"><img style="height: 50px;" src="${post[i].img_utente}" alt="img_utente" /></a>
                            <h3 class="col-3"><a href="profilo.php?id=${post[i].id_utente}" class="btn">${post[i].nome_utente}</a></h3>
                        </div>
                        <p>${post[i].data_post}</p>
                    </header>
                    <section>
        `;

        if(post[i].img_post != "./upload/"){
            result += `
                        <div>
                            <a href="${post[i].img_post}"><img style="height: 200px;" src="${post[i].img_post}" alt="img_post" /></a>
                        </div>`;
        }

        result += `
                        <p class="post_text text-justify">${post[i].testo_post}</p>
                    </section>
                    <footer>
                        <a href="post.php?post=${post[i].id_post}" class="btn">Commenti</a>
                    </footer>
                </article>
            </div>
        </div>
        `;
    }
    return result;
}

const main = document.querySelector(".main");

axios.get('api-post.php', {params: {source: "home"}}).then(response => {
    if(response.data.post.length === 0){
        main.innerHTML = `
            <div class="row">
                <div class="user col-10 offset-1 col-md-7 mt-2">
                    <p>Non ci sono post al momento.</p>
                </div>
            </div>`;
    } else {
        let post = printFollowedUsersPosts(response.data.post);
        main.innerHTML += post;
    }
});
