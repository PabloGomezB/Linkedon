<template>
    <div>
        <h1>Lista Ofertas</h1>
        <b-list-group>
            <b-list-group-item
                class="flex-column align-items-start"
                v-for="oferta in resultadoOfertas"
                :key="oferta.id"
            >
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ oferta.titol }}</h5>
                    <small>{{ oferta.data_publicacio }}</small>
                </div>
                <p class="mb-1">
                    {{ oferta.descripcio }}
                </p>
                <small>{{ oferta.ubicacio }}</small>
            </b-list-group-item>
        </b-list-group>
    </div>
</template>

<script>
export default {
    name: "ListaOfertas",
    data() {
        return {
            resultadoOfertas: "",
        };
    },
    methods: {
        getOfertas() {
            this.axios
                .get(
                    "http://labs.iam.cat/~a18jorcalari/Linkedon/api.php/records/oferta"
                )
                .then((response) => {
                    console.log("lista ofertas", response);
                    this.resultadoOfertas = response.data.records;
                });
        },
    },
    created() {
        this.getOfertas();
    },
};
</script>

<style></style>
