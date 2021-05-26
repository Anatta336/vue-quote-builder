module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  variants: {
    backgroundColor: ['group-hover', 'focus-within', 'hover', 'focus', 'odd', 'even'],
    // extend: {
    //   backgroundColor: ['odd'],
    // }
  },
  plugins: []
}
