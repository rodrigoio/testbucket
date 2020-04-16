99tests
=======
99tests is a tool that aims to assist the testing process by generating functional test cases.

About 99tests
---------------
This tool aims to generate test cases in an automated way, from the definition of a specification in YAML notation.
This specification aims to determine input domains, correlation between fields in a form.
As well as business rules and contexts.

Once we have a specification in a concrete and not subjective way, we can apply several known techniques of
software tests to actually generate test cases. The scope of this project is limited, for now, to generate integrated
tests not having a direct relationship with the application code, but with the specification of requirements.

If at any time you have realized how complex it is to deal with test cases, consider contributing to this project.

Expected Phases
---------------
This project is in course, and the expected phases are:

- [Layer of static and virtual domains][0]
- [Input domain specification layer with YML][1]
- [Data generation strategies based on static and virtual domains][2]
- [Implement results layer and output formats][3]
- [Implement console tool][4]
- [Specification of state-based tests][5]

Contact:
-------
If you want to contribute to this project, see the [guidelines][6]

[0]: https://github.com/rodrigoio/99tests/issues/16
[1]: https://github.com/rodrigoio/99tests/issues/17
[2]: https://github.com/rodrigoio/99tests/issues/18
[3]: https://github.com/rodrigoio/99tests/issues/19
[4]: https://github.com/rodrigoio/99tests/issues/20
[5]: https://github.com/rodrigoio/99tests/issues/21
[6]: https://github.com/rodrigoio/99tests/blob/master/CONTRIBUTING.md