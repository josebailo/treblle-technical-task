<template>
  <p v-if="$page.props.auth.user">Hello {{ $page.props.auth.user.name }}!</p>
  <p v-else>Please, do login or register yourself!</p>
</template>
