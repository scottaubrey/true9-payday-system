import { describe, expect, it, mock } from "bun:test";
import { render, screen } from "@testing-library/react";
import userEvent from "@testing-library/user-event";
import { PaydayForm, PaydayFormTestIds } from "./PaydayForm";

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

  it("Shows current month and year by default", () => {
    render(<PaydayForm />);

    const today = new Date();
    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    expect(monthField).toHaveValue(String(today.getUTCMonth() + 1));
    expect(yearField).toHaveValue(today.getUTCFullYear());
  });

  it("Shows a submit button", () => {
    render(<PaydayForm />);

    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);
    expect(submitButton).toBeVisible();
  });

  it("calls the callback when the submit button is pressed", async () => {
    const user = userEvent.setup();
    const callBack = mock((_year, _month) => {});
    render(<PaydayForm onSubmit={callBack} />);

    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);

    await user.selectOptions(monthField, "1");
    await user.clear(yearField);
    await user.type(yearField, "2026");
    await user.click(submitButton);

    expect(callBack).toHaveBeenCalledWith("2026", "1");
  });
});
