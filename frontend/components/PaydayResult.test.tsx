import { describe, expect, it } from "bun:test";
import { render, screen } from "@testing-library/react";
import { PaydayResult, PaydayResultTestIds } from "./PaydayResult";

describe("PaydayResult", () => {
  it("shows a pay date in the expected format", () => {
    render(<PaydayResult payDate={new Date("2026-10-30")} />);

    const payDateResult = screen.getByTestId(PaydayResultTestIds.payDate);
    expect(payDateResult).toHaveTextContent("Friday, 30/10/2026");
  });

  it.failing("shows a payment date in the expected format", () => {
    render(
      <PaydayResult
        payDate={new Date("2026-10-30")}
        paymentDate={new Date("2026-10-26")}
      />,
    );

    const payDateResult = screen.getByTestId(PaydayResultTestIds.paymentDate);
    expect(payDateResult).toHaveTextContent("Monday, 26/10/2026");
  });
});
