import { describe, test } from 'vitest'
import { render, screen } from '@testing-library/vue'
import Error from './Error.vue'

describe('Error component', () => {
    test('should render the text passed as slot', () => {
        render(Error, {
            slots: {
                default: 'Lorem ipsum'
            }
        })
        screen.getByText('Lorem ipsum')
    })
})
