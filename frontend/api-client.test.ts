import { afterAll, beforeEach, describe, expect, it, spyOn } from "bun:test";
import { ApiClient } from "./api-client";

const spyFetch = spyOn(globalThis, "fetch");

describe("ApiClient", () => {
  beforeEach(() => {
    spyFetch.mockReset();
  });

  afterAll(() => {
    spyFetch.mockRestore();
  });

  describe("payday", () => {
    it("fetches from the API", async () => {
      spyFetch.mockResolvedValueOnce(new Response());

      await ApiClient.payday("2026", "10");
      expect(spyFetch).toHaveBeenCalled();
    });

    it.failing("returns a success object for the payday view", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response('{"payDate":"2026-10-30","paymentDate":"2026-10-26"}'),
      );

      const response = await ApiClient.payday("2026", "10");

      if (!response.success) {
        expect().fail();
        return;
      }
      expect(response.data).toBe({
        payDate: new Date("2026-10-30"),
        paymentDate: new Date("2026-10-26"),
      });
    });
    it.todo("returns a error object when the api fails");
    it.todo("returns a error object when the data structure is incorrect");
  });
});
