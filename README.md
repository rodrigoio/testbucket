# Test Bucket
TestBucket is a tool that aims to assist the testing process by generating functional test cases.
<br>

## About
TestBucket aims to generate test cases based on specification using YAML notation.
The specification determine input domains and correlation between fields in a form.

Once we have a specification in a concrete and not subjective way, we can apply several known techniques to generate test cases.
The scope of this project is limited, for now, to generate integrated
tests not having a direct relationship with the application code, but with the specification.

Write an yaml specification with all you expect and the testbucket will generate all other cases for you!

## Contribute!
Consider contributing to this project!

We are working on an official channel, until then make a comment or open an issue to interact.
<br>


## Project Steps
Check out the development stages of this project:

| phases        | Status |
|---------------|--------|
| Config Loader | Done |
| Combine engine | Don |
| Range data types | Done |
| API | Pending |
| Docker pipeline | Pending |
| Types (text, dates, others) | Pending |
| Official Documentation | Pending |
<br>

## Running the development environment

### Useful commands:
```shell script

# build image
make build

# run all tests
make test

# run dev environment
make run

# stop dev environment
make stop
```
<br>

#### Data Types
##### Range Types:
| type          | Description | Status |
|---------------|-------------|--------|
| integer:range |    (...)    | Done   |
| float:range   |    (...)    | Pending |
| date:range    |    (...)    | Pending |
<br>

##### Static Types:
| type          | Description | Status |
|---------------|-------------|--------|
| string:static |    (...)    | Pending |
| boolean:static|    (...)    | Pending |
<br>

#### YAML Specification
```yaml
version: 1.0
group: UserForm
properties:
  - name: name
    type: static
    value: ["bob", "alice"]
  - name: surname
    type: static
    value: ["red", "green"]
```

#### Execute using container:
```shell script
docker run -it --rm --name testbucket-run -v "$PWD":/tmp testbucket ./testbucket testbucket:process --spec=/tmp/test.yaml --output=/tmp
```
<br>

#### Expected Data
Each line is a json object that defines a `TestCase` with properties and if its valid or not, and all values are encoded in base64.
This example only shows valid test cases: `is_valid=true`

```
{"group_name":"UserForm","properties":{"name":"Ym9i","surname":"cmVk"},"is_valid":true}
{"group_name":"UserForm","properties":{"name":"Ym9i","surname":"Z3JlZW4="},"is_valid":true}
{"group_name":"UserForm","properties":{"name":"YWxpY2U=","surname":"cmVk"},"is_valid":true}
{"group_name":"UserForm","properties":{"name":"YWxpY2U=","surname":"Z3JlZW4="},"is_valid":true}
```
<br>

#### Contribute:
If you want to contribute to this project, see the [guidelines][0]

[0]: https://github.com/rodrigoio/testbucket/blob/master/CONTRIBUTING.md
