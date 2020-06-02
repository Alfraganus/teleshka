<template>
    <div class="mx-4">
        <div class="px-10 py-4">
            <h1 class="title font-weight-medium">Foydalanuvchilar</h1>
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
                    <th class="text-left font-weight-bold">ID</th>
                    <th class="text-left font-weight-bold">Fullname</th>
                    <th class="text-left font-weight-bold">Email</th>
                    <th class="text-left font-weight-bold">Username</th>
                    <th class="text-left font-weight-bold">Role</th>              
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.index">
                    <td>{{ user.id }}</td>
                    <td>{{ user.fullname }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.role }}</td>
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
        users: []
    };
  },
  mounted(){
      this.$axios.get(this.$store.state.backend_url + '/api/users')
        .then((response) => {
            this.users = response.data;
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .then(function () {
            // always executed
        });
  }
};
</script>