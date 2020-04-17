<script>

import { Line } from "vue-chartjs";

export default {

    extends: Line,

    props: ["data"],

    data: () => ({

        labels: [],

        datasets: [
            {
                label: "Pacientes",
                borderColor: "transparent",
                data: [40, 39, 10, 40, 39, 80, 40],
                pointBackgroundColor: "#00796b",
                backgroundColor: "rgba(0, 121, 107, 0.6)",
                pointRadius: 0
            },
            {
                label: "Acompanhantes",
                borderColor: "transparent",
                pointBackgroundColor: "#303f9f",
                backgroundColor: "rgba(48, 63, 159, .6)",
                data: [20, 19, 16, 30, 30, 20, 10],
                pointRadius: 0
            },
            {
                label: "Tudo",
                borderColor: "transparent",
                pointBackgroundColor: "#1976d2",
                data: [60, 69, 30, 70, 133, 90, 70],
                backgroundColor: "rgba(25, 118, 210, 0.6)",
                pointRadius: 0
            }
        ],

        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: "bottom",
                usePointStyle: true,
                labels: {
                    fontSize: "14",
                    fontFamily: "'Roboto', 'sans-serif'"
                }
            },
            scales: {
                xAxes: [
                    {
                        gridLines: { display: false },
                        ticks: {
                        fontSize: "14",
                        fontFamily: "'Roboto', 'sans-serif'"
                        }
                    }
                ],
                yAxes: [
                    {
                        gridLines: { display: false },
                        ticks: {
                        fontSize: "14",
                        fontFamily: "'Roboto', 'sans-serif'"
                        }
                    }
            ]
            },
            tooltips: {
                //mode: 'index',
                intersect: false,
                backgroundColor: "#000",
                xPadding: 10,
                yPadding: 10,
                cornerRadius: 2,
                titleMarginBottom: 10,
                bodySpacing: 20,
                displayColors: true
            },
            hover: {
                intersect: false
            }
        }
    }),

    mounted() {

        this.labels = this.data.labels;
        this.datasets[0].data = this.data.data.pacientes;
        this.datasets[1].data = this.data.data.acompanhantes;
        this.datasets[2].data = this.data.data.passageiros;

        this.renderChart({
            labels: this.labels,
            datasets: this.datasets
        },this.options);
    }
};
</script>