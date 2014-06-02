BINARY=bin/scened
TARGET= $(BINARY)
LINK=g++
HOME=../
CINC=-I/usr/local/tsf4g/include -I/usr/local/tlibc/include -Itdr -Isource
LDPATH=-L/usr/local/tsf4g/lib -L/usr/local/tlibc/lib
DEPLIBS=-ltapp -ltlibc -llua -ldl
DEPOFILE=

TYPES_TDR_FILE=$(wildcard tdr/*.tdr)
READER_TDR_FILE=$(wildcard tdr/*.tdr)

CPPFILE=$(wildcard source/*.cpp)
CFILE=$(wildcard source/script/*.c)

DFILE=$(wildcard source/*.d)
DFILE+=$(wildcard tdr/*.d)
DFILE+=$(wildcard source/script/*.d)

include $(HOME)/build.mk

dep:
	@mkdir -p bin

cov:$(CFILE) $(CPPFILE)
	gcov -n -osource/ $^ | egrep -o '[0-9]+\.[0-9]+' | awk '{tot+=$$1}END{print "平均代码覆盖率: " tot/NR "%"}'

install:
	mkdir -p $(PREFIX)
	cp -rf bin $(PREFIX)

