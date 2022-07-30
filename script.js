
fetch('https://fakestoreapi.com/products/')
.then((res) =>{
    return res.json();
}).then((res) =>{
    populateDb(JSON.stringify(res));

})
const populateDb = (data) =>{
    const http = new XMLHttpRequest;
    http.onload = () =>{
        console.log(http.response)
    }

    http.open('POST', 'populate.php', true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send(`data=${encodeURIComponent(data)}`);
}

