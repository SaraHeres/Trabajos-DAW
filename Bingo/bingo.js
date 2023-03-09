
const layoutHTMLCarton = {
    tipo: "section",
    atributos: {
        name: "carton",
    },
    estilos: {
        backgroundColor: "lightgrey",
        width: "600px",
        height: "240px",
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
    },
};
const layoutHTMLLinea = {
    tipo: "div",
    atributos: {
        name: "linea",
    },
    estilos: {
        width: "600px",
        height: "70px",
        backgroundColor: "dodgerblue",
        border: "1px solid white",
        display: "flex",
        flexDirection: "row",
        justifyContent: "space-around",
        alignItems: "center",
    },
};
const layoutHTMLCelda = {
    tipo: "div",
    atributos: {
        name: "celda",
    },
    estilos: {
        height: "50px",
        width: "50px",
        backgroundColor: "whitesmoke",
        border: "1px solid snow",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        fontSize: "2em",
        fontFamily: "Arial",
        fontWeight: "bold",
    },

    //eventos
    eventos: [
        {
            evento: "click",
            funcion: (evento, objeto) => {
                if (objeto.numero != 0) {
                    if (objeto.estado == undefined || !objeto.estado) {
                        objeto.estado = true;
                        evento.target.style.filter = "invert(100%)";
                        Bingo.comprobarBingo(objeto.linea.carton.juego, objeto.linea, objeto.linea.carton);
                    } else {
                        objeto.estado = false;
                        evento.target.style.filter = " ";
                    }
                }
            }
        }
    ]
};

//layouts
const layoutHTMLMesa = {
    tipo: "div",
    atributos: {
        mesa: "mesa",
    },
    estilos: {
        display: "flex",
    },
};
const layoutHTMLAreaCartones = {
    tipo: "div",
    atributos: {
        name: "areaCartones",
    },
    estilos: {
        display: "flex",
        flexDirection: "column",
    },
};
const layoutHTMLMesaBombo = {
    tipo: "div",
    atributos: {
        mesa: "mesaBombo",
    },
    estilos: {
        display: "flex",
        flexDirection: "column",
    },
};
const layoutHTMLAreaBolas = {
    tipo: "div",
    atributos: {
        name: "areaBolas",
    },
    estilos: {
        display: "flex",
        width: "600px",
        flexDirection: "row",
        flexWrap: "wrap",
        justifyContent: "center",
    },
};
const layoutHTMLColumnaBolas = {
    tipo: "div",
    atributos: {
        name: "columnaBolas",
    },
    estilos: {
        display: "flex",
        width: "275px",
        flexDirection: "row",
        flexWrap: "wrap",
        justifyContent: "center",
    },
};
const layoutHTMLCarrilBolas = {
    tipo: "div",
    atributos: {
        name: "carrilBolas",
    },
    estilos: {
        display: "flex",
        width: "50px",
        flexDirection: "row",
        flexWrap: "wrap",
        justifyContent: "center",
    },
};
const layoutHTMLBombo = {
    tipo: "section",
    atributos: {
        name: "bombo",
    },
    estilos: {
        backgroundColor: "lightgrey",
        width: "600px",
        height: "240px",
        display: "flex",
        flexDirection: "column",
        alignItems: "center",
        justifyContent: "center",
    },
};
const layoutHTMLHuecoBola = {
    tipo: "div",
    atributos: {
        name: "huecoBola",
    },
    estilos: {
        display: "inline-block",
        background: "#cccccc",
        borderRadius: "100px",
        color: "#fff",
        width: "40px",
        height: "40px",
        lineHeight: "1.6em",
        marginRight: "15px",
        fontSize: "1.5em",
        fontFamily: "Arial",
        fontWeight: "bold",
        textAlign: "center",
        boxShadow: "7px 7px 5px 0px rgba(50, 50, 50, 0.75)",
    },
};
const layoutHTMLBola = {
    tipo: "div",
    atributos: {
        name: "bola",
    },
    estilos: {
        display: "inline-block",
        background: "#fd4d3f",
        borderRadius: "100px",
        color: "#fff",
        width: "40px",
        height: "40px",
        lineHeight: "1.6em",
        marginRight: "15px",
        fontSize: "1.5em",
        fontFamily: "Arial",
        fontWeight: "bold",
        textAlign: "center",
        boxShadow: "7px 7px 5px 0px rgba(50, 50, 50, 0.75)",
        bottom: "50px",
        position: "relative",
        transitionProperty: "bottom",
        transitionDuration: "2s",
    },
};
const layoutHTMLBotonBingo = {
    tipo: "button",
    atributos: {
        name: "botonBombo",
        fontSize: "4em",
    },
    eventos: [
        {
            evento: "click",

            funcion: (evento, objeto) => {

                let estado = evento.target.innerHTML;

                if (estado === "Girar") {
                    objeto.girando = false;
                    evento.target.innerHTML = "Parar";
                    estado = evento.target.innerHTML;
                    objeto.intervalo = setInterval(procesaBola, 3000);


                    function procesaBola() {

                        objeto.nuevaBola();
                        objeto.girando = true;

                        if (objeto.bolas.length === objeto.numeroDeBolas) {

                            clearInterval(objeto.intervalo);
                            evento.target.innerHTML = "FINALIZADO";
                            evento.target.disabled = true;
                        }
                    }
                } 
                
                else {

                    evento.target.innerHTML = "Girar";
                    objeto.girando = false;
                    estado = evento.target.innerHTML;
                    clearInterval(objeto.intervalo);
                }
            }
        }
    ]
}


function generarElementoHTML(layout, objeto) {

    if (layout != undefined) {

        let elementoHTML = document.createElement(layout.tipo);

        for (let atributo in layout.atributos) {
            elementoHTML.setAttribute(atributo, layout.atributos[atributo]);
        }

        for (let estilo in layout.estilos) {
            elementoHTML.style[estilo] = layout.estilos[estilo];
        }

        if (layout.eventos != undefined) {
            layout.eventos.forEach(ev => {
                elementoHTML.addEventListener(ev.evento, e => ev.funcion(e, objeto));
            })
        };


        return elementoHTML;
    }

    return null;
}


function numeroAleatorio(desde, hasta) {

    let n = parseInt(desde + Math.random() * (hasta - desde + 1));
    return n;
}

class Carton {


    constructor(juego, numeroBolasJuego = 90, numerosPorCarton = 15, numeroDeLineas = 3, numeroDeColumnas = 9, numerosPorLinea = 5, huecosPorLinea = 4) {
        this.juego = juego;
        this.numeroBolasJuego = numeroBolasJuego;
        this.numerosPorCarton = numerosPorCarton;
        this.numeroDeLineas = numeroDeLineas;
        this.numeroDeColumnas = numeroDeColumnas;
        this.numerosPorLinea = numerosPorLinea;
        this.huecosPorLinea = huecosPorLinea;
        this.ElementoHTML = generarElementoHTML(layoutHTMLCarton, this);
        this.numeros = [];
        this.lineas = [];
        this.generarLineas();
        document.body.insertAdjacentElement("beforeend", this.ElementoHTML);
    }


    generarLineas() {

        for (let i = 1; i <= 3; i++) {
            let desde = i * this.numeroDeColumnas - (this.numeroDeColumnas - 1);
            let hasta = i * this.numeroDeColumnas;

            let linea = new Linea(this, desde, hasta, this.huecosPorLinea, this.numeroDeColumnas);
            this.lineas.push(linea);
        }
    }
}

//Clase Linea
class Linea {

    constructor(carton, desde, hasta, numeroDeHuecos, numerosDeColumnas) {
        this.carton = carton;
        this.desde = desde;
        this.hasta = hasta;
        this.numeroDeHuecos = numeroDeHuecos;
        this.numeroDeColumnas = numerosDeColumnas;
        this.ElementoHTML = generarElementoHTML(layoutHTMLLinea, this);
        this.numeros = [];
        this.celdas = [];
        this.huecos = [];
        this.generarCeldas();
        this.carton.ElementoHTML.insertAdjacentElement("beforeend", this.ElementoHTML);
    }

    generarCeldas() {

        let huecos = this.generarHuecos();

        for (let i = 1; i <= this.numeroDeColumnas; i++) {
            let celda;

            if (huecos.includes(i)) {
                celda = new Celda(this, 0);
            } 
            
            else {

                let repetido = false;
                do {
                    let primero = (i - 1) * 10;
                    let ultimo = (i * 10 - 1);
                    if (i == 1) {
                        primero = primero + 1;
                    }
                    if (i == this.numeroDeColumnas) {
                        ultimo = ultimo + 1;

                    }
                    var numero = numeroAleatorio(primero, ultimo);
                    if (this.carton.numeros.find((element) => element == numero) !== undefined) {
                        repetido = true;
                    } 
                    
                    else {
                        this.carton.numeros.push(numero);
                        repetido = false;
                    }

                } 
                
                while (repetido);

                celda = new Celda(this, numero);
            }
            this.celdas.push(celda);
        }
    }


    estaEnCarton(n) {

        for (let i = 0; i < this.carton.lineas.length; i++) {
            let linea = this.carton.lineas[i];

            for (let j = 0; j < linea.celdas.length; j++) {
                let celda = linea.celdas[j];

                if (celda.numero == n) {
                    return true;
                }
            }
        }

        return false;
    }


    generarHuecos() {

        let h = [];

        while (h.length < 5) {
            let n = numeroAleatorio(1, this.numeroDeColumnas);

            if (h.indexOf(n) == -1) {
                h.push(n);
            }
        }

        return h;
    }
}



//Clase Celda

class Celda {
    constructor(linea, numero) {

        this.linea = linea;
        if (numero == 0) {
            this.numero = "";
        }
        
        else {
            this.numero = numero;
        }

        this.ElementoHTML = generarElementoHTML(layoutHTMLCelda, this);
        this.ElementoHTML.innerHTML = this.numero;
        this.linea.ElementoHTML.insertAdjacentElement("beforeend", this.ElementoHTML);

    }

}

//Clase Bingo

class Bingo {

    constructor(numeroDeBolas = 90, numeroDeCartones = 3, numerosPorCarton = 15, lineas = 3, columnas = 9) {
        this.numeroDeBolas = numeroDeBolas;
        this.numeroDeCartones = numeroDeCartones;
        this.numerosPorCarton = numerosPorCarton;
        this.lineas = lineas;
        this.columnas = columnas;
        this.cartones = [];
        this.bolas = [];
        this.numeros = [];
        this.girando = false;
        this.lineaCantada = false;

        this.mesaHTML = generarElementoHTML(layoutHTMLMesa, this);
        document.body.insertAdjacentElement("beforeend", this.mesaHTML);
        this.areaCartonesHTML = generarElementoHTML(layoutHTMLAreaCartones, this);
        this.mesaHTML.insertAdjacentElement("beforeend", this.areaCartonesHTML);


        this.generarCartones();

        this.mesaBomboHTML = generarElementoHTML(layoutHTMLMesaBombo, this);
        this.mesaHTML.insertAdjacentElement("beforeend", this.mesaBomboHTML);
        this.bomboHTML = generarElementoHTML(layoutHTMLBombo, this);
        this.mesaBomboHTML.insertAdjacentElement("beforeend", this.bomboHTML);
        this.botonBingoHTML = generarElementoHTML(layoutHTMLBotonBingo, this);
        this.bomboHTML.insertAdjacentElement("beforeend", this.botonBingoHTML);
        this.botonBingoHTML.innerHTML = "Girar";

        this.generarTablaDeBolas();
    }



    
    
    generarTablaDeBolas() {
        this.areaBolasHTML = generarElementoHTML(layoutHTMLAreaBolas, this);
        this.mesaBomboHTML.insertAdjacentElement("beforeend", this.areaBolasHTML);
        this.columnasBolasDerechaHTML = generarElementoHTML(layoutHTMLColumnaBolas, this);
        this.areaBolasHTML.insertAdjacentElement("beforeend", this.columnasBolasDerechaHTML);
        this.carrilBolasHTML = generarElementoHTML(layoutHTMLCarrilBolas, this);
        this.areaBolasHTML.insertAdjacentElement("beforeend", this.carrilBolasHTML);
        this.columnasBolasIzquierdaHTML = generarElementoHTML(layoutHTMLColumnaBolas, this);
        this.areaBolasHTML.insertAdjacentElement("beforeend", this.columnasBolasIzquierdaHTML);
        let y = 1;
        for (let i = 1; i <= this.numeroDeBolas; i++) {
            let elementoHTMLhueco = generarElementoHTML(layoutHTMLHuecoBola, this);
            elementoHTMLhueco.innerHTML = i;
            elementoHTMLhueco.setAttribute("id", i);
            let elementoRaiz = y > 5 ? this.columnasBolasIzquierdaHTML : this.columnasBolasDerechaHTML;
            elementoRaiz.insertAdjacentElement("beforeend", elementoHTMLhueco);
            y = y >= 10 ? 1 : y + 1;
        }
    }
    generarCartones() {
        for (let i = 1; i <= this.numeroDeCartones; i++) {

            let carton = new Carton(
                this,
                this.numeroDeBolas,
                this.numerosPorCarton,
                this.lineas,
                this.columnas

            );

            this.cartones.push(carton);

            this.areaCartonesHTML.insertAdjacentElement('afterbegin', carton.ElementoHTML);
        }
    }


    nuevaBola() {
        let aleatorio = numeroAleatorio(1, this.numeroDeBolas);
        while (this.numeros.indexOf(aleatorio) != -1) {
            aleatorio = numeroAleatorio(1, this.numeroDeBolas);
        }

        let bola = new Bola(this, aleatorio);
        this.bolas.push(bola);
        this.numeros.push(aleatorio);

        let tempo = setTimeout(function () {
            bola.elementoHTML.style.bottom = "-500px";

            let tempo = setTimeout(() => {
                let casilla = document.getElementById(aleatorio);
                let bottomposition = casilla.style.bottom;
                bola.elementoHTML.style.bottom = bottomposition;
                casilla.replaceWith(bola.elementoHTML);
                bola.elementoHTML.style.boxShadow = "7px 7px 5px 0px rgba(50, 50, 0.75)";
                bola.elementoHTML.style.transitionProperty = "bottom";
                bola.elementoHTML.style.transitionDuration = "2s";
            }, 1000);
        }, 1000);
    }


    static comprobarBingo(bingo, linea, carton) {

        let cantaLinea = linea.celdas.every((celda) => celda.numero == 0 || celda.estado);
        let cantaBingo = false;
        let lineaOK = false;
        let bingoOK = false;
        let arrancarBingo = false;

        if (cantaLinea) {
            let evento = new Event("click");
            let arrancarBingo = false;

            if (bingo.girando && !bingo.lineaCantada) {
                arrancarBingo = true;
                bingo.botonBingoHTML.dispatchEvent(evento);
            }

            lineaOK = Bingo.comprobarLinea(bingo, linea);

            linea.estado = lineaOK;

        }


        if (lineaOK) {
            if (!bingo.lineaCantada) {
                alert("Linea!!");
                bingo.lineaCantada = true;

            }

            linea.celdas.forEach((celda) => (celda.ElementoHTML.style.backgroundColor = "red"));
            cantaBingo = carton.lineas.every((linea) => (linea.estado));

            if (cantaBingo) {
                bingoOK = Bingo.revisarBingo(carton);
                if (bingoOK == true) {
                    alert("Bingo !!!");
                }

            }

        }

        if (arrancarBingo) {
            bingo.botonBingoHTML.dispatchEvent(evento);
        }
    }

    //metodo comprobarLinea
    static comprobarLinea(bingo, linea) {
        const lineaOK = linea.celdas.every((celda) =>
            celda.numero != 0 ? bingo.numeros.includes(celda.numero) : true);
        return lineaOK;

    }

    static revisarBingo(carton) {
        const bingoOK = carton.lineas.every((linea) =>
            linea.celdas.every((celda) =>
                celda.numero != 0 ? carton.juego.numeros.includes(celda.numero) : true
            )
        );
        return bingoOK;

    }
}

//Clase Bola


class Bola {
    constructor(bingo, numero) {
        this.bingo = bingo;
        this.numero = numero;
        this.elementoHTML = generarElementoHTML(layoutHTMLBola, this);
        this.elementoHTML.innerHTML = numero;
        bingo.carrilBolasHTML.insertAdjacentElement("beforeend", this.elementoHTML);
    }
}
let mibingo = new Bingo();
