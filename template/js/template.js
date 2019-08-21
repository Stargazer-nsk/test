// Все "переходы" осуществляются с помощью ajax.

document.addEventListener('DOMContentLoaded', function(){
    goTo();
});

async function onClick() {

    let ajax = this.getAttribute('data-ajax');
    let parent = this.getAttribute('data-parent');
    let params = {
        data: ajax,
        parent: parent
    };

    let data = new FormData();
    data.append( "json", JSON.stringify( params ) );

    let result = await fetch('./index.php', {
        method: 'POST',
        body: data
    });

    document.querySelector('.main').innerHTML = await result.text();

    goTo();
}

function goTo() {
    let go_to = document.querySelectorAll('.go_to');
    for( let i=0; i<go_to.length; i++ ){
        go_to[i].addEventListener('click', onClick);
    }
}