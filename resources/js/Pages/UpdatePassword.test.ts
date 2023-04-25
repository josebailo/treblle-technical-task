import { afterEach, describe, expect, test, vi } from 'vitest'
import { cleanup, fireEvent, render, screen } from '@testing-library/vue'
import UpdatePassword from './UpdatePassword.vue'

describe('UpdatePassword component', () => {
    afterEach(() => {
        cleanup()
    })

    test('does not allow to do submit until the fields are filled', async () => {
        const mockSubmit = vi.fn()
        render(UpdatePassword, { global: { mocks: { submit: mockSubmit } } })
        const submitButton = screen.getByText(/update/i)
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const nameInput = screen.getByLabelText(/^password/i)
        await fireEvent.update(nameInput, '1234')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const emailInput = screen.getByLabelText(/^new password/i)
        await fireEvent.update(emailInput, 'qwerty')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const passwordInput = screen.getByLabelText(/^confirm new password/i)
        await fireEvent.update(passwordInput, 'qwerty')
        await fireEvent.click(submitButton)
        expect(mockSubmit).toHaveBeenCalled()
    })
})
