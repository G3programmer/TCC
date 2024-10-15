// Converte a data de vencimento para o formato de data do JavaScript
const dataVencimentoDate = new Date(dataVencimento).getTime();

// Verifica se a data de vencimento foi convertida corretamente
if (isNaN(dataVencimentoDate)) {
    console.error("Data de vencimento inválida: ", dataVencimento);
    document.getElementById("cronometro").innerHTML = "Erro ao calcular a data de vencimento.";
} else {
    // Atualiza o temporizador a cada segundo
    const x = setInterval(function() {
        const agora = new Date().getTime(); // Hora atual
        const distancia = dataVencimentoDate - agora; // Tempo restante

        // Cálculos de tempo
        const dias = Math.floor(distancia / (1000 * 60 * 60 * 24));
        const horas = Math.floor((distancia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutos = Math.floor((distancia % (1000 * 60 * 60)) / (1000 * 60));
        const segundos = Math.floor((distancia % (1000 * 60)) / 1000);

        // Exibe o temporizador no elemento desejado
        document.getElementById("cronometro").innerHTML = dias + "d " + horas + "h " + minutos + "m " + segundos + "s ";

        // Se o temporizador terminar, exibe uma mensagem
        if (distancia < 0) {
            clearInterval(x);
            document.getElementById("cronometro").innerHTML = "O plano expirou!";
        }
    }, 1000);
}
