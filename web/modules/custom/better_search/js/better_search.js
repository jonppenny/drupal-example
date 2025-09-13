/**
 * @file
 */

((Drupal, once) => {
  /**
   * Clears the search field when clear button is clicked.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the behavior to the form wrapper.
   */
  Drupal.behaviors.creoSearch = {
    attach(context) {
      once(
        'block-better-search',
        '.block-better-search',
        context,
      ).forEach((block) => {
        const btnClear = block.querySelector('.clear');
        const targetInput = btnClear.closest('form')?.querySelector('#better-search');
        btnClear.addEventListener('click', () => {
          targetInput.value = '';
        });
      });
    },
  };
})(Drupal, once);
