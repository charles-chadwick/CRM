<!--suppress JSUnresolvedReference -->
<script setup>
const props = defineProps ( { contacts: Array | Object } )
console.log(props);

</script>

<template>
  <table class="w-full table-auto text-sm">
    <thead>
    <tr>
      <th>Type</th>
      <th>Phone</th>
      <th>Fax</th>
      <th>Email</th>
      <th>Address 1</th>
      <th>Address 2</th>
      <th>City</th>
      <th>State</th>
      <th>Postal Code</th>
      <th>Country</th>
      <th>Notes</th>
    </tr>
    </thead>
    <tbody>
    <tr
        v-for="contact in contacts"
        :key="contact.id"
    >
      <td>{{ contact.attributes.type }}</td>
      <td>{{ contact.attributes.phone }}</td>
      <td>{{ contact.attributes.fax }}</td>
      <td>{{ contact.attributes.email }}</td>
      <td>{{ contact.attributes.address_1 }}</td>
      <td>{{ contact.attributes.address_2 }}</td>
      <td>{{ contact.attributes.city }}</td>
      <td>{{ contact.attributes.state }}</td>
      <td>{{ contact.attributes.postal_code }}</td>
      <td>{{ contact.attributes.country }}</td>
      <td>{{ contact.attributes.notes }}</td>
    </tr>
    </tbody>
  </table>
</template>

<style scoped>

</style>