<template>
    <div class="mx-4">
        <div class="px-10 py-4">
            <h1 class="title font-weight-medium">Teleshkalar</h1>
        </div>
        <div>
             <v-subheader class="primary py-8 px-10" dark>
                 <v-btn  color="success" dark>Yangi qo'shish</v-btn>
             </v-subheader>
        </div>
        <v-simple-table fixed-header height="auto">
            <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left font-weight-bold">Ko'rinishi</th>
                    <th class="text-left font-weight-bold">Kodi</th>
                    <th class="text-left font-weight-bold">Raqami</th>
                    <th class="text-left font-weight-bold">Firmasi</th>
                    <th class="text-left font-weight-bold">Yili</th>
                    <th class="text-left font-weight-bold">Moto/Soat</th>
                    <th class="text-left font-weight-bold">Inventer №</th>
                    <th class="text-left font-weight-bold">Ekspluatatsiya</th>                
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in desserts" :key="item.name">
                    <td>{{ item.img }}</td>
                    <td>{{ item.code }}</td>
                    <td>{{ item.number }}</td>
                    <td>{{ item.fir }}</td>
                    <td>{{ item.date }}</td>
                    <td>{{ item.hour }}</td>
                    <td>{{ item.iNumber }}</td>
                    <td>{{ item.bol }}</td>
                </tr>
            </tbody>
            </template>
        </v-simple-table>
    </div>  
</template>

<script>
export default {
  data() {
    return {
      desserts: [
          {
            img: 'Korinishi',
            code: 'A',
            number: 85,
            fir: 'DOOSAN Korea D-50S-2',
            date: 2005,
            hour: 20405,
            iNumber: 20100119/1,
            bol: 'Taminot',
          },
          {
            img: 'Korinishi',
            code: 'A',
            number: 85,
            fir: 'DOOSAN Korea D-50S-2',
            date: 2005,
            hour: 20405,
            iNumber: 20100119/1,
            bol: 'Taminot',
          },
          
        ],
    };
  },
  mounted(){
  }
};
</script>