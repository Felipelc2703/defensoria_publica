<template>
    <div class="container">
        <div class="text-center">
            <h2>REQUISITOS</h2>
             <v-btn class="mb-4"
                @click="agregarRequisito" >
                <v-icon icon="mdi-text-box-edit-outline"></v-icon>
            </v-btn>
        </div>
        <v-select
        label="Seleccione el tipo de requisito"
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
        >

        </v-select>
    </div>



    <EasyDataTable
      v-model:items-selected="itemsSelected"
      :headers="headers"
      :items="items"
    />
    <br />
    items selected:<br />
    {{ itemsSelected }}
  </template>
  
  <script lang="ts">
  import { defineComponent, ref } from "vue";
//   import { mockClientItems } from "./mock";
  import { Header, Item } from "vue3-easy-data-table";
  
  export default defineComponent({
    setup() {
      const headers: Header[] = [
        { text: "PLAYER", value: "player" },
        { text: "TEAM", value: "team" },
        { text: "NUMBER", value: "number" },
        { text: "POSITION", value: "position" },
        { text: "HEIGHT", value: "height" },
        { text: "WEIGHT (lbs)", value: "weight", sortable: true },
        { text: "LAST ATTENDED", value: "lastAttended" },
        { text: "COUNTRY", value: "country" },
      ];
  
      const items: Item[] = [
        {
          player: "Stephen Curry",
          team: "GSW",
          number: 30,
          position: "G",
          height: "6-2",
          weight: 185,
          lastAttended: "Davidson",
          country: "USA",
        },
        {
          player: "Lebron James",
          team: "LAL",
          number: 6,
          position: "F",
          height: "6-9",
          weight: 250,
          lastAttended: "St. Vincent-St. Mary HS (OH)",
          country: "USA",
        },
        {
          player: "Kevin Durant",
          team: "BKN",
          number: 7,
          position: "F",
          height: "6-10",
          weight: 240,
          lastAttended: "Texas-Austin",
          country: "USA",
        },
        {
          player: "Giannis Antetokounmpo",
          team: "MIL",
          number: 34,
          position: "F",
          height: "6-11",
          weight: 242,
          lastAttended: "Filathlitikos",
          country: "Greece",
        },
      ];
  
      const itemsSelected: Item[] = ref([]);
  
      return {
        headers,
        items,
        itemsSelected,
      };
    },
    methods: {
        agregarRequisito() {

        }

    }
  });
  </script>
  