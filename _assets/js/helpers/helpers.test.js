import {version} from './helpers.js';

/**
 * Test the version function
 */
test('test version number is string', () => {
    expect(typeof version()).toBe('string');
});
