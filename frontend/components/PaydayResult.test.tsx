import { describe, expect, it } from "bun:test";
import { render, screen } from "@testing-library/react";
import { PaydayResult, PaydayResultTestIds } from "./PaydayResult";

describe("PaydayResult", () => {
  it.failing("shows a pay date in the expected format", () => {
    render(<PaydayResult payDate={new Date("2026-10-30")} />);

    const payDateResult = screen.getByTestId(PaydayResultTestIds.payDate);
    expect(payDateResult).toHaveTextContent("Friday, 30/10/2026");
  });

  it.todo("shows a payment date in the expected format");
});
