import { describe, expect, it, mock } from "bun:test";
import { render, screen } from "@testing-library/react";
import userEvent from "@testing-library/user-event";
import { PaydayForm, PaydayFormTestIds } from "./PaydayForm";

mock.module("../api-client.ts", () => ({
  ApiClient: {
    payday: mock(() => {}),
  },
}));

describe("PaydayForm", () => {
  it("Shows a month field", () => {
    render(<PaydayForm />);

    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    expect(monthField).toBeVisible();
  });

  it("Shows a year field", () => {
    render(<PaydayForm />);

    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    expect(yearField).toBeVisible();
  });

  it("Shows a submit button", () => {
    render(<PaydayForm />);

    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);
    expect(submitButton).toBeVisible();
  });

  it("Retrieves data from the API when the submit button is pressed", async () => {
    const user = userEvent.setup();
    const { ApiClient } = await import("../api-client.ts");
    render(<PaydayForm />);

    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);

    await user.selectOptions(monthField, "1");
    await user.clear(yearField);
    await user.type(yearField, "2026");
    await user.click(submitButton);

    expect(ApiClient.payday).toHaveBeenCalledWith("2026", "1");
  });

  it.todo("Shows the pay and payment date on success");
  it.todo("Shows an error message on failure");
});
