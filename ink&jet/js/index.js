function generateFollowedUserSPosts(pubblicazioni){
    let result = "";

    for(let i = 0; i < pubblicazioni.length; i++){
        let pubblicazione = `
        <div class="row">
            <div class="col-10 offset-1 col-md-7 mt-2 post">
                <article>
                    <header>
                        <div class="row mb-2">
                            <a href="profilo.php?id=${pubblicazioni[i].id_utente}" class="col-2"><img style="height: 50px;" src="${pubblicazioni[i].img_utente}" alt="img_utente" /></a>
                            <h3 class="col-3"><a href="profilo.php?id=${pubblicazioni[i].id_utente}" class="btn">${pubblicazioni[i].nome_utente}</a></h3>
                        </div>
                        <p>${pubblicazioni[i].data_pubblicazione}</p>
                    </header>
                    <section>
        `;

        if(pubblicazioni[i].img_pubblicazione != "./upload/"){
            pubblicazione += `
                        <div>
                            <a href="${pubblicazioni[i].img_pubblicazione}"><img style="height: 200px;" src="${pubblicazioni[i].img_pubblicazione}" alt="img_post" /></a>
                        </div>`;
        }

        pubblicazione += `
                        <p class="post_text text-justify">${pubblicazioni[i].testo_pubblicazione}</p>
                    </section>
                    <footer>
                        <a href="post.php?post=${pubblicazioni[i].id_pubblicazione}" class="btn">Commenti</a>
                    </footer>
                </article>
            </div>
        </div>
        `;

        result += pubblicazione;
    }
    return result;
}

let num_posts = 5;
let row_offset = 0;
let post_totali;
const main = document.querySelector(".main");

function getData(){
    row_offset += num_posts;
    axios.get('api-pubblicazione.php', {params: { num_posts: num_posts, row_offset: (row_offset - num_posts) }}).then(response => {
        post_totali = response.data.num;
        if(post_totali === 0){
            main.innerHTML = `
                <div class="row">
                    <div class="user col-10 offset-1 col-md-7 mt-2">
                        <p>Non ci sono post al momento.</p>
                    </div>
                </div>`;
        } else if(row_offset < post_totali + num_posts){
            let pubblicazioni = generateFollowedUserSPosts(response.data.post);
            main.innerHTML += pubblicazioni;
        }
    });
}

// infinte scroll
window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY + 100 >= document.body.offsetHeight) {
        getData();
    }
});

getData();