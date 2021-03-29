<template>
    <div>
        <h1>Lista Ofertas</h1>
        <b-list-group v-if="isOfertasObtenidas && ofertas.length != 0">
            <b-list-group-item
                class="flex-column align-items-start"
                v-for="oferta in ofertas"
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
        <div v-else-if="!isOfertasObtenidas" class="text-center mt-5">
            <b-spinner label="Loading..."></b-spinner>
        </div>
        <div v-else-if="ofertas.length == 0">
            <p>No se han encontrado datos.</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "ListaOfertas",
    props: {
        isOfertasObtenidas: Boolean,
        ofertas: Array,
    },
};
</script>

<style></style>
